<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employer;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

use Illuminate\Http\RedirectResponse;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class PricingController extends Controller
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
    public function checkSubscription(User $users){
        $date1 = $users->subscribe_until;
        $date2 = Carbon::now()->format('Y-m-d');
        if($date1<$date2){
            $users->plan = 'Free';
            $users->save();
        }
    }
    public function index(){
        $id = auth()->user()->id;
        $users = User::find($id);
        $this->checkSubscription($users);
        if($users->role_id==1){
            $freelancer = Freelancer::where('users_id', $id);
            return view('Subscription', ['users'=>$users, 'freelancer'=>$freelancer]);
        }
        if($users->role_id==2){
            $employer = Employer::where('users_id', $id);
            return view('Subscription', ['users'=>$users, 'employer'=>$employer]);
        }
    }
    public function business()
    {
        Stripe::setApiKey(config('stripe.sk'));

        $session = Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'idr',
                        'product_data' => [
                            'name' => 'Business Plan',
                        ],
                        'unit_amount'  => 20000000,
                    ],
                    'quantity'   => 1,
                ],
            ],
            'mode'        => 'payment',
            'success_url' => route('scs_business'),
            'cancel_url'  => route('pricing'),
        ]);

        return redirect()->away($session->url);
    }
    public function scs_business()
    {
        $id = auth()->user()->id;
        $users = User::find($id);
        $users->plan = 'Business';
        $users->subscribe_until = Carbon::now()->addDays(30)->format('Y-m-d');
        $users->save();
        if($users->role_id==1){
            $freelancer = Freelancer::where('users_id', $id);
            return view('Subscription', ['users'=>$users, 'freelancer'=>$freelancer]);
        }
        if($users->role_id==2){
            $employer = Employer::where('users_id', $id);
            return view('Subscription', ['users'=>$users, 'employer'=>$employer]);
        }
    }
    public function professional()
    {
        Stripe::setApiKey(config('stripe.sk'));

        $session = Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'idr',
                        'product_data' => [
                            'name' => 'Professional Plan',
                        ],
                        'unit_amount'  => 50000000,
                    ],
                    'quantity'   => 1,
                ],
            ],
            'mode'        => 'payment',
            'success_url' => route('scs_professional'),
            'cancel_url'  => route('pricing'),
        ]);

        return redirect()->away($session->url);
    }
    public function scs_professional()
    {
        $id = auth()->user()->id;
        $users = User::find($id);
        $users->plan = 'Professional';
        $users->subscribe_until = Carbon::now()->addDays(30)->format('Y-m-d');
        $users->save();
        if($users->role_id==1){
            $freelancer = Freelancer::where('users_id', $id);
            return view('Subscription', ['users'=>$users, 'freelancer'=>$freelancer]);
        }
        if($users->role_id==2){
            $employer = Employer::where('users_id', $id);
            return view('Subscription', ['users'=>$users, 'employer'=>$employer]);
        }
    }
}
