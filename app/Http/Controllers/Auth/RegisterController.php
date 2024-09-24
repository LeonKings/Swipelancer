<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Field;
use App\Models\Study;
use App\Models\Employer;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, RedirectsUsers;


    public function newAccount(Request $request)
    {
        $newUsers = $request->validate([
            'role_id' =>'required'
        ]);
        $field = Field::all();
        $study = Study::all();
        session([
            'role_id' => $request->role_id,
            'field' => $field,
            'study' => $study
        ]);

        // Redirect to the named route 'register'
        return redirect()->route('register');

    }
    public function role(){
        return view ('auth.role');
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if($data['role_id']==1){
            $validator = Validator::make($data, [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role_id' => ['required'],
                'freelancer_image_link'=> ['required', 'image', 'mimes:jpg,jpeg,png'],
                'freelancer_name'=> ['required'],
                'last_study'=> ['required'],
                'field_of_work'=> ['required'],
                'cv_link'=> ['required'],
                'portfolio'=> ['required'],
                'min_salary'=> ['required'],
                'max_salary'=> ['required'],
                'section_1'=> ['required'],
                'section_2'=> ['required'],
                'section_3'=> ['required'],
                'describe_yourselves'=> ['required'],
                'plan'=> ['required']
            ]);
            return Validator::make($data, [
                'email' => ['unique:users', 'required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role_id' => ['required'],
                'freelancer_image_link'=> ['required', 'image', 'mimes:jpg,jpeg,png'],
                'freelancer_name'=> ['required'],
                'last_study'=> ['required'],
                'field_of_work'=> ['required'],
                'cv_link'=> ['required'],
                'portfolio'=> ['required'],
                'min_salary'=> ['required'],
                'max_salary'=> ['required'],
                'section_1'=> ['required'],
                'section_2'=> ['required'],
                'section_3'=> ['required'],
                'describe_yourselves'=> ['required'],
                'plan'=> ['required']
            ]);
        }
        if($data['role_id']==2){
            $validator = Validator::make($data, [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role_id' => ['required'],
                'employer_image_link'=> ['required', 'image', 'mimes:jpg,jpeg,png'],
                'employer_type'=> ['required'],
                'employer_name'=> ['required' , 'string', 'max:255'],
                'plan'=> ['required']
            ]);
            return Validator::make($data, [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role_id' => ['required'],
                'employer_image_link'=> ['required', 'image', 'mimes:jpg,jpeg,png'],
                'employer_type'=> ['required'],
                'employer_name'=> ['required' , 'string', 'max:255'],
                'plan'=> ['required']
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $date = Carbon::now()->format('Y-m-d');
        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => $data['role_id'],
            'plan' => $data['plan'],
            'subscribe_until' => $date,
            'swipe_count' => 0,
            'swipe_date' => $date
        ]);
        $last = DB::table('users')->latest()->first();
        $id = $last->id;
        if($data['role_id']==1){
            if ($data['min_salary']>$data['max_salary']) {
                $temp = $data['min_salary'];
                $data['min_salary'] = $data['max_salary'];
                $data['max_salary'] = $temp;
            }
            $newFreelancer = array(
                'freelancer_image_link'=> $data['freelancer_image_link'],
                'users_id' => $id,
                'freelancer_name'=> $data['freelancer_name'],
                'last_study'=> $data['last_study'],
                'field_of_work'=> $data['field_of_work'],
                'cv_link'=> $data['cv_link'],
                'portfolio'=> $data['portfolio'],
                'min_salary'=> $data['min_salary'],
                'max_salary'=> $data['max_salary'],
                'section_1'=> $data['section_1'],
                'section_2'=> $data['section_2'],
                'section_3'=> $data['section_3'],
                'describe_yourselves'=> $data['describe_yourselves']
            );
            $file = $data['freelancer_image_link'];
            $imageName = time().'.'.$file->getClientOriginalExtension();
            Storage::putFileAs('public\img', $file, $imageName);
            $newFreelancer['freelancer_image_link'] = $imageName;
            $file2 = $data['cv_link'];
            $cv_file = time().'.'.$file2->getClientOriginalExtension();
            Storage::putFileAs('public\cv', $file2, $cv_file);
            $newFreelancer['cv_link'] = $cv_file;
            $newFreelancer['created_community'] = 0;
            Freelancer::create($newFreelancer);
        }
        if($data['role_id']==2){
            $newEmployer = array(
                'users_id' => $id,
                'employer_image_link' => $data['employer_image_link'],
                'employer_type' =>$data['employer_type'],
                'employer_name' =>  $data['employer_name'],
            );
            $file = $data['employer_image_link'];
            $imageName = time().'.'.$file->getClientOriginalExtension();
            Storage::putFileAs('public\img', $file, $imageName);
            $newEmployer['employer_image_link'] = $imageName;
            Employer::create($newEmployer);
        }
        return $user;
    }
}
