<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Freelancer;
use App\Models\User;
use App\Models\Job;
use App\Models\Field;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    /**
     * @return View|Factory|Application
     */

    /**
     * @return RedirectResponse
     * @throws ApiErrorException
     */

     public function index()
{
    $id = auth()->user()->id;
    $users = User::find($id);
    app('App\Http\Controllers\PricingController')->checkSubscription($users);
    $field = Field::all();

    if ($users->role_id == 2) {
        $employer = Employer::where('users_id', $id)->first();

        if ($employer) {
            // Calculate job limits
            switch ($users->plan) {
                case 'Free':
                    $jobLimit = 1;
                    break;
                case 'Business':
                    $jobLimit = 10;
                    break;
                case 'Professional':
                    $jobLimit = 50;
                    break;
                default:
                    $jobLimit = 0;
            }

            $jobCount = Job::where('employers_id', $employer->id)->count();
            $canAddJob = $jobCount < $jobLimit;

            return view('AddJob', [
                'users' => $users,
                'employer' => $employer,
                'field' => $field,
                'canAddJob' => $canAddJob
            ]);
        }
    }

    return redirect()->back()->with('error', 'User is not an employer.');
}


    public function index2($jobId)
{
    $id = auth()->user()->id;
    $users = User::find($id);
    app('App\Http\Controllers\PricingController')->checkSubscription($users);
    $fields = Field::all();
    $job = Job::find($jobId);

    if ($users->role_id == 2) {
        $employer = Employer::where('users_id', $id)->first();
        if ($employer && $job && $job->employers_id == $employer->id) {
            return view('editJob', [
                'users' => $users,
                'employer' => $employer,
                'fields' => $fields,
                'jobs' => $job
            ]);
        }
    }

    return redirect()->route('home')->with('error', 'Unauthorized access.');
}

public function addJob(Request $request)
{
    $users = User::find($request->userID);
    $employer = Employer::find($request->employerID);

    $validatedData = $request->validate([
        'project_name' => ['required'],
        'project_description' => ['required'],
        'project_type' => ['required'],
        'address' => ['required'],
        'project_section' => ['required'],
        'project_field' => ['required'],
        'project_deadline' => ['required'],
        'salary' => ['required']
    ]);

    $newJob = array(
        'employers_id' => $employer->id,
        'status' => 'open',
        'address' => $validatedData['address'],
        'project_name'=> $validatedData['project_name'],
        'project_type'=> $validatedData['project_type'],
        'project_description' => $validatedData['project_description'],
        'salary' => $validatedData['salary'],
        'project_field' => $validatedData['project_field'],
        'project_section' => $validatedData['project_section'],
        'project_deadline'=> $validatedData['project_deadline']
    );

    Job::create($newJob);

    // Return JSON response to handle with JavaScript
    return response()->json(['success' => true, 'message' => 'Job added successfully.']);
}


public function editJob(Request $request)
{
    $validatedData = $request->validate([
        'project_type' => ['required'],
        'project_description' => ['required'],
        'address' => ['required'],
        'project_field' => ['required'],
        'project_section' => ['required'],
        'project_deadline' => ['required', 'date'],
        'salary' => ['required', 'numeric']
    ]);

    $job = Job::find($request->jobID);

    if ($job) {
        $job->project_type = $validatedData['project_type'];
        $job->project_description = $validatedData['project_description'];
        $job->address = $validatedData['address'];
        $job->project_field = $validatedData['project_field'];
        $job->project_section = $validatedData['project_section'];
        $job->project_deadline = $validatedData['project_deadline'];
        $job->salary = $validatedData['salary'];
        $job->save();

        return response()->json(['success' => 'Job updated successfully.']);
    } else {
        return response()->json(['error' => 'Job not found.'], 404);
    }
}


public function closeJob($jobId)
{
    $job = Job::find($jobId);
    $job->status = 'closed';
    $job->save();

    return response()->json(['message' => 'Job closed successfully']);
}

public function openJob($jobId)
{
    $job = Job::find($jobId);
    $job->status = 'open';
    $job->save();

    return response()->json(['message' => 'Job closed successfully']);
}

public function deleteJob($id)
{
    $job = Job::find($id);
    if ($job) {
        $job->delete();
        return response()->json(['success' => true, 'message' => 'Job deleted successfully']);
    } else {
        return response()->json(['success' => false, 'message' => 'Job not found'], 404);
    }
}


}
