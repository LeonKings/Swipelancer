<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Freelancer;
use App\Models\User;
use App\Models\Job;
use App\Models\ListMatch;
use App\Models\Field;
use App\Models\Section;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     public function index()
{
    $id = auth()->user()->id;
    $users = User::find($id);
    app('App\Http\Controllers\PricingController')->checkSubscription($users);
    $sections = Section::all();

    // Calculate swipe limits
    $today = now()->toDateString();
    $swipeLimit = 0;
    $swipeCount = $users->swipe_count;

    switch ($users->plan) {
        case 'Free':
            $swipeLimit = 15;
            $jobLimit = 1;
            break;
        case 'Business':
            $swipeLimit = 50;
            $jobLimit = 10;
            break;
        case 'Professional':
            $swipeLimit = PHP_INT_MAX; // No limit for Professional
            $jobLimit = 50;
            break;
    }

    if ($users->swipe_date != $today) {
        $users->swipe_count = 0;
        $users->swipe_date = $today;
        $swipeCount = 0;
        $users->save();
    }

    if ($users->role_id == 1) {
        
        $freelancer = Freelancer::where('users_id', $id)->first();

        // Get the freelancer's field of work ID
        $fieldId = $freelancer->field_of_work;

        // Get job ids that the freelancer has already interacted with
        $interactedJobIds = ListMatch::where('freelancer_id', $freelancer->id)
                                     ->whereNotNull('freelancer_status')
                                     ->pluck('job_id')
                                     ->toArray();

        // Retrieve jobs where project_field matches the freelancer's field of work ID
        // and the freelancer has not interacted with them
        $jobs = Job::where('project_field', $fieldId)
                    ->whereNotIn('id', $interactedJobIds)
                    ->where('status', 'open')
                    ->with(['employer', 'field', 'section'])
                    ->inRandomOrder()
                    ->get();

        return view('home', [
            'users' => $users,
            'freelancer' => $freelancer,
            'jobs' => $jobs,
            'sections' => $sections,
            'swipeLimit' => $swipeLimit,
            'swipeCount' => $swipeCount
        ]);
    }

    if ($users->role_id == 2) {
        $employer = Employer::where('users_id', $id)->first();
        $jobs = Job::where('employers_id', $employer->id)->get();

        $jobCount = Job::where('employers_id', $employer->id)->count();
        $canAddJob = $jobCount < $jobLimit;

        return view('home', [
            'users' => $users,
            'employer' => $employer,
            'jobs' => $jobs,
            'sections' => $sections,
            'swipeLimit' => $swipeLimit,
            'swipeCount' => $swipeCount,
            'canAddJob' => $canAddJob // Pass the flag to the view
        ]);
    }
}

    public function sectionFilter(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        if ($user->plan == 'Free') {
            return redirect()->back()->with('error', "Upgrade to Business Plan or Professional Plan to use this feature.");
        } else {
            $id = auth()->user()->id;
            $users = User::find($id);
            $sections = Section::all();
            $section_filter = Section::where('section', $request->section_filter)->first();
            $section_filter_id = $section_filter->id;
            $today = now()->toDateString();
            $swipeLimit = 0;
            $swipeCount = $users->swipe_count;
        
            switch ($users->plan) {
                case 'Free':
                    $swipeLimit = 15;
                    $jobLimit = 1;
                    break;
                case 'Business':
                    $swipeLimit = 50;
                    $jobLimit = 10;
                    break;
                case 'Professional':
                    $swipeLimit = PHP_INT_MAX; // No limit for Professional
                    $jobLimit = 50;
                    break;
            }
        
            if ($users->swipe_date != $today) {
                $users->swipe_count = 0;
                $users->swipe_date = $today;
                $swipeCount = 0;
                $users->save();
            }

            if ($users->role_id == 1) {
                $freelancer = Freelancer::where('users_id', $id)->first();

                // Get the freelancer's field of work ID
                $fieldId = $freelancer->field_of_work;

                // Get job ids that the freelancer has already interacted with
                $interactedJobIds = ListMatch::where('freelancer_id', $freelancer->id)
                                            ->whereNotNull('freelancer_status')
                                            ->pluck('job_id')
                                            ->toArray();

                // Retrieve jobs where project_field matches the freelancer's field of work ID
                // and the freelancer has not interacted with them
                // and the section matches the requested section
                $jobs = Job::where('project_field', $fieldId)
                            ->whereNotIn('id', $interactedJobIds)
                            ->where('status', 'open')
                            ->where('project_section', $section_filter_id)
                            ->with('employer', 'field', 'section')
                            ->get();

                return view('home', [
                    'users' => $users,
                    'freelancer' => $freelancer,
                    'jobs' => $jobs,
                    'sections' => $sections,
                    'swipeLimit' => $swipeLimit,
                    'swipeCount' => $swipeCount
                ]);
            }
        }
    }
}
