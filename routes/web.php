<?php

use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\matchesController;
use App\Http\Controllers\matchingJobController;
use App\Http\Controllers\listMatchController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify'=>true]);
Route::get('/role', [RegisterController::class, 'role']);
Route::post('/Register', [RegisterController::class, 'newAccount']);
Route::get('getSection/{id}', function ($id) {
    $section = Section::where('fields_id',$id)->get();
    return response()->json($section);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home/filter', [App\Http\Controllers\HomeController::class, 'sectionFilter']);

Route::get('/profile', [ProfileController::class, 'index']);
Route::get('/download/{file}', function ($file) {
    return response()->download(storage_path('app/public/cv/'.$file));
});
Route::post('/UpdateFreelancer/{userID}/{freelancerID}', [ProfileController::class, 'updateFreelancer']);
Route::post('/UpdateEmployer/{userID}/{employerID}', [ProfileController::class, 'updateEmployer']);

Route::get('/subscription', [PricingController::class, 'index'])->name('pricing');
Route::post('/business', [PricingController::class, 'business'])->name('business');
Route::get('/scs_business', [PricingController::class, 'scs_business'])->name('scs_business');
Route::post('/professional', [PricingController::class, 'professional'])->name('professional');
Route::get('/scs_professional', [PricingController::class, 'scs_professional'])->name('scs_professional');

Route::get('/chat', [ChatController::class, 'index']);
Route::get('/chat/{id}', [ChatController::class, 'chat']);
Route::post('/chat/{id}', [ChatController::class, 'sendMessage']);
Route::get('/chat-data/{id}', [ChatController::class, 'fetchChatData']);

Route::get('/community', [CommunityController::class, 'index']);
Route::get('/community/create', [CommunityController::class, 'createPage']);
Route::post('/community/create', [CommunityController::class, 'create']);
Route::get('/community/mine/{id}', [CommunityController::class, 'myCommunity']);
Route::get('/community/edit/{id}', [CommunityController::class, 'editCommunity']);
Route::post('/community/edit/{id}', [CommunityController::class, 'updateCommunity']);
Route::post('/community/delete/{id}', [CommunityController::class, 'deleteCommunity']);
Route::post('/community/search', [CommunityController::class, 'searchCommunity']);
Route::post('/community/mine/{id}/search', [CommunityController::class, 'searchMyCommunity']);

Route::get('/addJob', [JobController::class, 'index']);
Route::post('/addJob', [JobController::class, 'addJob'])->name('addJob');
Route::get('/editJob/{jobId}', [JobController::class, 'index2'])->name('editJob');
Route::post('/editJob', [JobController::class, 'editJob'])->name('editJobPost');
Route::get('/closeJob/{jobId}', [JobController::class, 'closeJob'])->name('closeJob');
Route::get('/openJob/{jobId}', [JobController::class, 'openJob'])->name('openJob');
Route::delete('/deleteJob/{id}', [JobController::class, 'deleteJob']);

Route::get('/matches', [matchesController::class, 'index']);
Route::post('/matches/filter/{jobId}', [matchesController::class, 'sectionFilter']);

Route::get('/checkSwipeLimit', [ListMatchController::class, 'checkSwipeLimit'])->name('checkSwipeLimit');
Route::post('/swipe', [ListMatchController::class, 'swipe'])->name('swipe');

