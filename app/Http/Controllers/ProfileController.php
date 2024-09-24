<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use App\Models\Study;
use App\Models\Section;
use App\Models\Employer;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index(){
        $id = auth()->user()->id;
        $users = User::find($id);
        app('App\Http\Controllers\PricingController')->checkSubscription($users);
        $field = Field::all();
        $study = Study::all();
        $section = Section::all();
        if($users->role_id==1){
            $freelancer = Freelancer::all();
            foreach($freelancer as $fl){
                if($fl->users_id==$id){
                    $frela = $fl;
                    return view('profile', ['users'=>$users, 'freelancer'=>$frela, 'field'=>$field, 'study'=>$study, 'section'=>$section]);
                }
            }
        }
        if($users->role_id==2){
            $employer = Employer::all();
            foreach($employer as $em){
                if($em->users_id==$id){
                    $empl = $em;
                    return view('profile', ['users'=>$users, 'employer'=>$empl, 'field'=>$field, 'study'=>$study]);
                }
            }
        }
    }

    public function updateFreelancer(Request $request, $userId, $freelancerId){
        $users = User::find($userId);
        app('App\Http\Controllers\PricingController')->checkSubscription($users);
        $freelancer = Freelancer::find($freelancerId);
        if ($request->password != "") {
            $rules = [
                'password' => ['required', 'min:8', 'confirmed']
            ];
            $newData = $request->validate($rules);

            $users->password = $request->password;
            $users['password'] = bcrypt($users['password']);
            $users->save();
        }
        $rules = [
            'freelancer_image_link'=> ['image', 'mimes:jpg,jpeg,png'],
            'freelancer_name'=> ['required'],
            'last_study'=> ['required'],
            'field_of_work'=> ['required'],
            'portfolio'=> ['required'],
            'min_salary'=> ['required'],
            'max_salary'=> ['required'],
            'section_1'=> ['required'],
            'section_2'=> ['required'],
            'section_3'=> ['required'],
            'describe_yourselves'=> ['required']
        ];
        $newData = $request->validate($rules);

        $freelancer->freelancer_name = $request->freelancer_name;
        $freelancer->last_study = $request->last_study;
        $freelancer->field_of_work = $request->field_of_work;
        $freelancer->portfolio = $request->portfolio;
        if ($request->min_salary > $request->max_salary) {
            $freelancer->min_salary = $request->max_salary;
            $freelancer->max_salary = $request->min_salary;
        } else {
            $freelancer->min_salary = $request->min_salary;
            $freelancer->max_salary = $request->max_salary;
        }
        $freelancer->section_1 = $request->section_1;
        $freelancer->section_2 = $request->section_2;
        $freelancer->section_3 = $request->section_3;
        $freelancer->describe_yourselves = $request->describe_yourselves;
        if ($request->hasFile('freelancer_image_link')) {
            $path = '/storage/public/img/' . $freelancer->freelancer_image_link;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->freelancer_image_link;
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('public/img', $file, $imageName);
            $freelancer['freelancer_image_link'] = $imageName;
        }
        if ($request->hasFile('cv_link')) {
            $path = '/storage/public/cv/' . $freelancer->cv_link;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file2 = $request->cv_link;
            $cv_file = time() . '.' . $file2->getClientOriginalExtension();
            Storage::putFileAs('public/cv', $file2, $cv_file);
            $freelancer['cv_link'] = $cv_file;
        }
        $users->save();
        $freelancer->save();
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updateEmployer(Request $request, $userId, $employerId){
        $users = User::find($userId);
        app('App\Http\Controllers\PricingController')->checkSubscription($users);
        $employer = Employer::find($employerId);
        if ($request->password != "") {
            $rules = [
                'password' => ['required', 'min:8', 'confirmed']
            ];
            $newData = $request->validate($rules);

            $users->password = $request->password;
            $users['password'] = bcrypt($users['password']);
            $users->save();
        }
        $rules = [
            'employer_image_link'=> ['image', 'mimes:jpg,jpeg,png'],
            'employer_type'=> ['required'],
            'employer_name'=> ['required' , 'string', 'max:255']
        ];
        $newData = $request->validate($rules);

        $employer->employer_type = $request->employer_type;
        $employer->employer_name = $request->employer_name;
        if ($request->hasFile('employer_image_link')) {
            $path = '/storage/public/img/' . $employer->employer_image_link;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->employer_image_link;
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('public/img', $file, $imageName);
            $employer['employer_image_link'] = $imageName;
        }
        $users->save();
        $employer->save();
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
