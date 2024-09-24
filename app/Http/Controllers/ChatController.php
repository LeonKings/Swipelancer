<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chat;
use App\Models\Employer;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use App\Models\ListMatch;
use App\Models\Job;
use App\Models\Section;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $id = auth()->user()->id;
        $users = User::find($id);
        app('App\Http\Controllers\PricingController')->checkSubscription($users);

        if ($users->role_id == 1) {
            // For freelancers
            $freelancer = Freelancer::where('users_id', $id)->first();

            if ($freelancer) {
                // Step 1: Retrieve ListMatch entries where the freelancer is matched
                $listMatches = ListMatch::where('freelancer_id', $freelancer->id)
                                        ->where('status', 'match')
                                        ->get();

                // Step 2: Extract job IDs from these matched entries
                $jobIds = $listMatches->pluck('job_id');

                // Step 3: Retrieve jobs using these job IDs to get the corresponding employer IDs
                $jobs = Job::whereIn('id', $jobIds)->with('field')->get();

                // Step 4: Fetch unique employers based on these employer IDs
                $employerIds = $jobs->pluck('employers_id')->unique();
                $matchedEmployers = Employer::whereIn('id', $employerIds)->get();

                return view('listMatch', ['matched' => $matchedEmployers, 'users' => $users, 'jobs' => $jobs]);
            }
        } elseif ($users->role_id == 2) {
            // For employers
            $employer = Employer::where('users_id', $id)->first();

            if ($employer) {
                // Step 1: Retrieve all jobs posted by the employer
                $jobsPostedByEmployer = Job::where('employers_id', $employer->id)->get();

                // Step 2: Extract job IDs from the jobs posted by the employer
                $jobIds = $jobsPostedByEmployer->pluck('id');

                // Step 3: Retrieve all ListMatch entries where the job_id matches the job IDs and the status is 'match'
                $listMatches = ListMatch::whereIn('job_id', $jobIds)
                                        ->where('status', 'match')
                                        ->get();

                // Step 4: Extract unique freelancer IDs from the ListMatch entries
                $freelancerIds = $listMatches->pluck('freelancer_id')->unique();

                // Step 5: Retrieve freelancer details using the unique freelancer IDs
                $matchedFreelancers = Freelancer::whereIn('id', $freelancerIds)->get();

                return view('listMatch', ['matched' => $matchedFreelancers, 'users' => $users, 'jobs' => $jobsPostedByEmployer]);
            }
        }

        // In case no data is found, return with empty matched collection
        return view('listMatch', ['matched' => collect(), 'users' => $users, 'jobs' => collect()]);
    }

    public function chat(Request $request, $id)
{
    $userId = auth()->user()->id;

    // Ensure the user is authenticated
    if (!auth()->check()) {
        abort(403);
    }

    $users = auth()->user();
    $matched = User::find($id);
    $jobs = collect(); // Initialize $jobs to avoid undefined variable error
    $freelancers = collect(); // Initialize $freelancers to avoid undefined variable error

    if ($users->role_id == 1) {
        // For freelancers
        $chatWith = Employer::where('users_id', $id)->first();
        $myName = Freelancer::with(['field', 'section1', 'section2', 'section3'])->where('users_id', $userId)->first();

        // Retrieve ListMatch entries where the freelancer is matched
        $listMatches = ListMatch::where('freelancer_id', $myName->id)
                                ->where('status', 'match')
                                ->get();

        // Extract job IDs from these matched entries
        $jobIds = $listMatches->pluck('job_id');

        // Retrieve jobs using these job IDs
        $jobs = Job::whereIn('id', $jobIds)->with('field')->get();

    } elseif ($users->role_id == 2) {
        // For employers
        $chatWith = Freelancer::where('users_id', $id)->first();
        $myName = Employer::where('users_id', $userId)->first();

        // Retrieve the employer details
        $employer = Employer::where('users_id', $userId)->first();

        if ($employer) {
            // Retrieve all jobs posted by the employer
            $jobsPostedByEmployer = Job::where('employers_id', $employer->id)->with('field')->get();

            // Extract job IDs from the jobs posted by the employer
            $jobIds = $jobsPostedByEmployer->pluck('id');

            // Retrieve all ListMatch entries where the job_id matches the job IDs, freelancer_id is the chatWith's id, and the status is 'match'
            $listMatches = ListMatch::whereIn('job_id', $jobIds)
                                    ->where('freelancer_id', $chatWith->id)
                                    ->where('status', 'match')
                                    ->get();

            // Extract unique job IDs from the ListMatch entries
            $matchedJobIds = $listMatches->pluck('job_id')->unique();

            // Filter the jobs posted by the employer to get only the matched jobs
            $jobs = $jobsPostedByEmployer->filter(function ($job) use ($matchedJobIds) {
                return $matchedJobIds->contains($job->id);
            });

            // Retrieve the freelancers matched with the employer's jobs
            $freelancerIds = $listMatches->pluck('freelancer_id')->unique();
            $freelancers = Freelancer::with(['field', 'section1', 'section2', 'section3'])
                                    ->whereIn('id', $freelancerIds)
                                    ->get();
        }
    }

    $chats = Chat::where(function ($query) use ($userId, $id) {
        $query->where('chat_with', $userId)->where('sender', $id);
    })->orWhere(function ($query) use ($userId, $id) {
        $query->where('chat_with', $id)->where('sender', $userId);
    })->get();

    return view('chat', [
        'matched' => $matched,
        'users' => $users,
        'chats' => $chats,
        'myName' => $myName,
        'chatWith' => $chatWith,
        'jobs' => $jobs,
        'freelancers' => $freelancers
    ]);
}


    public function sendMessage(Request $request)
    {
        $newMessage = $request->validate([
            'message' => 'required|min:1|max:500',
        ]);

        $newMessage['chat_with'] = $request->id;
        $newMessage['sender'] = auth()->user()->id;

        Chat::create($newMessage);

        return redirect()->back();
    }
    
    public function fetchChatData($id)
    {
        $userId = auth()->user()->id;
    
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return response()->json([], 403);
        }
    
        $chats = Chat::where(function ($query) use ($userId, $id) {
            $query->where('chat_with', $userId)->where('sender', $id);
        })->orWhere(function ($query) use ($userId, $id) {
            $query->where('chat_with', $id)->where('sender', $userId);
        })->get();
    
        return response()->json($chats);
    }



}
