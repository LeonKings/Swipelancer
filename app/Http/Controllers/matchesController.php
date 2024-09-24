<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Freelancer;
use App\Models\User;
use App\Models\ListMatch;
use App\Models\Section;
use Illuminate\Support\Facades\Log;

class MatchesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request)
    {
        // Log::info('Incoming request data:', $request->all());

        $id = auth()->user()->id;
        $users = User::find($id);
        app('App\Http\Controllers\PricingController')->checkSubscription($users);
        $jobId = $request->input('job_id');
        $job = Job::findOrFail($jobId);

        // Log::info('Authenticated user ID:', ['id' => $id]);
        // Log::info('Authenticated user details:', $users->toArray());

        $sections = Section::all();

        $interactedFreelancerIds = ListMatch::where('job_id', $job->id)
                                             ->whereNotNull('job_status')
                                             ->pluck('freelancer_id')
                                             ->toArray();

        $freelancers = Freelancer::where('field_of_work', $job->project_field)
                                  ->whereNotIn('id', $interactedFreelancerIds)
                                  ->with(['field', 'section1', 'section2', 'section3'])
                                  ->inRandomOrder()
                                  ->get();

        // Log::info('Retrieved freelancers:', $freelancers->toArray());
        // Log::info('Interacted Freelancer IDs:', $interactedFreelancerIds);
        // Log::info('Job:', $job->toArray());

        switch ($users->plan) {
            case 'Free':
                $swipeLimit = 15;
                break;
            case 'Business':
                $swipeLimit = 50;
                break;
            case 'Professional':
                $swipeLimit = PHP_INT_MAX;
                break;
        }

        $swipeCount = $users->swipe_count;
        $swipeDate = $users->swipe_date;

        if ($swipeDate !== now()->toDateString()) {
            $swipeCount = 0;
            $users->swipe_count = 0;
            $users->swipe_date = now()->toDateString();
            $users->save();
            // Log::info('Swipe count reset for user ID:', $users->id);
        }

        return view('matches', compact('job', 'freelancers', 'users', 'sections', 'swipeCount', 'swipeLimit'));
    }

    public function sectionFilter(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        app('App\Http\Controllers\PricingController')->checkSubscription($user);
        if ($user->plan == 'Free') {
            return redirect()->back()->with('error', "Upgrade to Business Plan or Professional Plan to use this feature.");
        } else {
            $id = auth()->user()->id;
            $users = User::find($id);
            $sections = Section::all();
            $section_filter = Section::where('section', $request->section_filter)->first();
            $section_filter_id = $section_filter->id;

            $jobId = $request->jobId;
            $job = Job::findOrFail($jobId);

            $interactedFreelancerIds = ListMatch::where('job_id', $job->id)
                                                 ->whereNotNull('job_status')
                                                 ->pluck('freelancer_id')
                                                 ->toArray();

            $freelancers = Freelancer::where('field_of_work', $job->project_field)
                                      ->whereNotIn('id', $interactedFreelancerIds)
                                      ->where(function ($query) use ($section_filter_id) {
                                          $query->where('section_1', $section_filter_id)
                                                ->orWhere('section_2', $section_filter_id)
                                                ->orWhere('section_3', $section_filter_id);
                                      })
                                      ->with(['field', 'section1', 'section2', 'section3'])
                                      ->inRandomOrder()
                                      ->get();

            switch ($users->plan) {
                case 'Free':
                    $swipeLimit = 15;
                    break;
                case 'Business':
                    $swipeLimit = 50;
                    break;
                case 'Professional':
                    $swipeLimit = PHP_INT_MAX;
                    break;
            }

            $swipeCount = $users->swipe_count;
            $swipeDate = $users->swipe_date;

            if ($swipeDate !== now()->toDateString()) {
                $swipeCount = 0;
                $users->swipe_count = 0;
                $users->swipe_date = now()->toDateString();
                $users->save();
                // Log::info('Swipe count reset for user ID:', $users->id);
            }

            return view('matches', compact('job', 'freelancers', 'users', 'sections', 'swipeCount', 'swipeLimit'));
        }
    }
}
