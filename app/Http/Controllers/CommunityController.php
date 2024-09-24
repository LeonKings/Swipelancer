<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\User;
use App\Http\Requests\StoreCommunityRequest;
use App\Http\Requests\UpdateCommunityRequest;
use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\Freelancer;
use App\Models\Job;

class CommunityController extends Controller
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

        if($users->role_id == 1){

            $communities = Community::all();
            return view('community', ['users' => $users, 'communities'=>$communities]);

        }
        if ($users->role_id == 2) {
            $employer = Employer::where('users_id', $id)->first();
            $jobs = Job::where('employers_id', $employer->id)->get();

            // Log for debugging
            // \Log::info('Employer:', ['employer' => $employer]);
            // \Log::info('Jobs for Employer:', ['jobs' => $jobs]);

            return view('home', ['users' => $users, 'employer' => $employer, 'jobs' => $jobs]);
        }
    }

    public function createPage()
    {
        //
        $id = auth()->user()->id;
        $users = User::find($id);

        if($users->role_id == 1){

            $id = auth()->user()->id;
            $users = User::find($id);
            return view('createCommunity', ['users' => $users]);

        }
        if ($users->role_id == 2) {
            $employer = Employer::where('users_id', $id)->first();
            $jobs = Job::where('employers_id', $employer->id)->get();

            // \Log for debugging
            // \Log::info('Employer:', ['employer' => $employer]);
            // \Log::info('Jobs for Employer:', ['jobs' => $jobs]);

            return view('home', ['users' => $users, 'employer' => $employer, 'jobs' => $jobs]);
        }
    }

    public function myCommunity()
    {
        $id = auth()->user()->id;
        $users = User::find($id);

        if($users->role_id == 1){
            $communities = Community::where('users_id', $id)->get();
            return view('myCommunity', ['communities'=>$communities, 'users' => $users]);
        }
        if ($users->role_id == 2) {
            $employer = Employer::where('users_id', $id)->first();
            $jobs = Job::where('employers_id', $employer->id)->get();

            // Log for debugging
            // \Log::info('Employer:', ['employer' => $employer]);
            // \Log::info('Jobs for Employer:', ['jobs' => $jobs]);

            return view('home', ['users' => $users, 'employer' => $employer, 'jobs' => $jobs]);
        }
    }

    public function editCommunity(Request $request)
    {
        $id = auth()->user()->id;
        $users = User::find($id);

        if($users->role_id == 1){
            $id = $request->id;
            $community = Community::find($id);

            return view('editCommunity', ['users'=> $users, 'community'=>$community]);
        }
        if ($users->role_id == 2) {
            $employer = Employer::where('users_id', $id)->first();
            $jobs = Job::where('employers_id', $employer->id)->get();

            // Log for debugging
            // \Log::info('Employer:', ['employer' => $employer]);
            // \Log::info('Jobs for Employer:', ['jobs' => $jobs]);

            return view('home', ['users' => $users, 'employer' => $employer, 'jobs' => $jobs]);
        }
    }

    public function updateCommunity(Request $request)
{
    $id = auth()->user()->id;
    $users = User::find($id);

    if ($users->role_id == 1) {
        $community = Community::find($request->id);

        $rules = [
            'community_name' => 'required|min:1|max:25|',
            'community_desc' => 'required|min:1|max:500|',
            'community_url' => 'required|min:1|max:500|',
        ];
        $newData = $request->validate($rules);

        $community->community_name = $request->community_name;
        $community->community_desc = $request->community_desc;
        $community->community_url = $request->community_url;

        $community->save();

        return redirect()->back()->with('success', 'Community updated successfully!');
    }
    if ($users->role_id == 2) {
        $employer = Employer::where('users_id', $id)->first();
        $jobs = Job::where('employers_id', $employer->id)->get();

        // Log for debugging
        // \Log::info('Employer:', ['employer' => $employer]);
        // \Log::info('Jobs for Employer:', ['jobs' => $jobs]);

        return view('home', ['users' => $users, 'employer' => $employer, 'jobs' => $jobs]);
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request)
{
    $id = auth()->user()->id;
    $users = User::find($id);

    if ($users->role_id == 1) {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $freelancer = Freelancer::where('users_id', $user_id)->first();

        if ($user->plan == 'Free') {
            return redirect()->back()->with('error', "Upgrade to Business Plan or Professional Plan to Create a Community.");
        }
        if ($user->plan == 'Business' && $freelancer->created_community > 5) {
            return redirect()->back()->with('error', "Maximum limit reached. Please upgrade to Professional Plan to create more communities.");
        } else {
            $community = $request->validate([
                'community_name' => 'required',
                'community_desc' => 'required',
                'community_url' => 'required'
            ]);

            $community['users_id'] = auth()->user()->id;

            Community::create($community);

            $freelancer->created_community += 1;
            $freelancer->save();

            return redirect()->back()->with('success', 'Community created successfully!');
        }
    }
    if ($users->role_id == 2) {
        $employer = Employer::where('users_id', $id)->first();
        $jobs = Job::where('employers_id', $employer->id)->get();

        // Log for debugging
        // \Log::info('Employer:', ['employer' => $employer]);
        // \Log::info('Jobs for Employer:', ['jobs' => $jobs]);

        return view('home', ['users' => $users, 'employer' => $employer, 'jobs' => $jobs]);
    }
}

public function deleteCommunity(Request $request)
{
    $id = auth()->user()->id;
    $users = User::find($id);

    if ($users->role_id == 1) {
        $community = Community::find($request->id);

        if ($community) {
            $community->delete();

            $freelancer = Freelancer::where('users_id', $id)->first();
            $freelancer->created_community -= 1;
            $freelancer->save();

            return response()->json(['success' => 'Community deleted successfully!']);
        } else {
            return response()->json(['error' => 'Community not found!'], 404);
        }
    } else if ($users->role_id == 2) {
        $employer = Employer::where('users_id', $id)->first();
        $jobs = Job::where('employers_id', $employer->id)->get();

        // Log for debugging
        // \Log::info('Employer:', ['employer' => $employer]);
        // \Log::info('Jobs for Employer:', ['jobs' => $jobs]);

        return response()->json(['error' => 'You are not authorized to delete this community!'], 403);
    }
}


    public function searchCommunity(Request $request){
        // if(!auth()->check()) {
        //     abort(403);
        // }
        // $user = auth()->user();

        $id = auth()->user()->id;
        $users = User::find($id);

        if($users->role_id == 1){
            $communities = Community::where('community_name', 'LIKE', "%$request->search%")->get();
            return view('community', ['users' => $users,'communities'=>$communities]);
        }
        if ($users->role_id == 2) {
            $employer = Employer::where('users_id', $id)->first();
            $jobs = Job::where('employers_id', $employer->id)->get();

            // Log for debugging
            // \Log::info('Employer:', ['employer' => $employer]);
            // \Log::info('Jobs for Employer:', ['jobs' => $jobs]);

            return view('home', ['users' => $users, 'employer' => $employer, 'jobs' => $jobs]);
        }
    }

    public function searchMyCommunity(Request $request){
        // if(!auth()->check()) {
        //     abort(403);
        // }
        // $user = auth()->user();
        $id = auth()->user()->id;
        $users = User::find($id);

        if($users->role_id == 1){
            $id = auth()->user()->id;

            $communities = Community::where('users_id', $id)
            ->where(function ($query) use ($request) {
                $query->where('community_name', 'LIKE', "%$request->search%");
            })
            ->get();
            return view('myCommunity', ['communities'=>$communities, 'users'=>$users]);
        }
        if ($users->role_id == 2) {
            $employer = Employer::where('users_id', $id)->first();
            $jobs = Job::where('employers_id', $employer->id)->get();

            // Log for debugging
            // \Log::info('Employer:', ['employer' => $employer]);
            // \Log::info('Jobs for Employer:', ['jobs' => $jobs]);

            return view('home', ['users' => $users, 'employer' => $employer, 'jobs' => $jobs]);
        }
    }

}
