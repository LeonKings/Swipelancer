<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListMatch;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ListMatchController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function swipe(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            $freelancerId = $request->input('freelancer_id');
            $jobId = $request->input('job_id');
            $action = $request->input('action'); // 'like' or 'dislike'

            // Log incoming data
            // Log::info('Swipe action', [
            //     'user_id' => $userId,
            //     'freelancer_id' => $freelancerId,
            //     'job_id' => $jobId,
            //     'action' => $action
            // ]);

            // Check swipe limits
            $today = now()->toDateString();
            $swipeLimitReached = false;

            if ($user->plan == 'Free') {
                if ($user->swipe_date == $today) {
                    if ($user->swipe_count < 15) {
                        $user->swipe_count++;
                        // Log::info('Swipe count incremented for Free plan', [
                        //     'user_id' => $userId,
                        //     'swipe_count' => $user->swipe_count
                        // ]);
                    } else {
                        $swipeLimitReached = true;
                        // Log::info('Swipe limit reached for Free plan', [
                        //     'user_id' => $userId,
                        //     'swipe_count' => $user->swipe_count
                        // ]);
                    }
                } else {
                    $user->swipe_count = 1;
                    $user->swipe_date = $today;
                    // Log::info('Swipe count reset for Free plan', [
                    //     'user_id' => $userId,
                    //     'swipe_count' => $user->swipe_count,
                    //     'swipe_date' => $user->swipe_date
                    // ]);
                }
            } elseif ($user->plan == 'Business') {
                if ($user->swipe_date == $today) {
                    if ($user->swipe_count < 50) {
                        $user->swipe_count++;
                        // Log::info('Swipe count incremented for Business plan', [
                        //     'user_id' => $userId,
                        //     'swipe_count' => $user->swipe_count
                        // ]);
                    } else {
                        $swipeLimitReached = true;
                        // Log::info('Swipe limit reached for Business plan', [
                        //     'user_id' => $userId,
                        //     'swipe_count' => $user->swipe_count
                        // ]);
                    }
                } else {
                    $user->swipe_count = 1;
                    $user->swipe_date = $today;
                    // Log::info('Swipe count reset for Business plan', [
                    //     'user_id' => $userId,
                    //     'swipe_count' => $user->swipe_count,
                    //     'swipe_date' => $user->swipe_date
                    // ]);
                }
            } elseif ($user->plan == 'Professional') {
                if ($user->swipe_date == $today) {
                    $user->swipe_count++;
                    // Log::info('Swipe count incremented for Professional plan', [
                    //     'user_id' => $userId,
                    //     'swipe_count' => $user->swipe_count
                    // ]);
                } else {
                    $user->swipe_count = 1;
                    $user->swipe_date = $today;
                    // Log::info('Swipe count reset for Professional plan', [
                    //     'user_id' => $userId,
                    //     'swipe_count' => $user->swipe_count,
                    //     'swipe_date' => $user->swipe_date
                    // ]);
                }
            }

            if ($swipeLimitReached) {
                // Log::info('Swipe limit reached', [
                //     'user_id' => $userId,
                //     'plan' => $user->plan,
                //     'swipe_date' => $user->swipe_date,
                //     'swipe_count' => $user->swipe_count
                // ]);
                return response()->json(['status' => 'error', 'message' => 'You have reached your swipe limit for today.'], 403);
            }

            $user->save();

            if ($user->role_id == 1) {
                // Freelancer swipe action
                $match = ListMatch::where('freelancer_id', $freelancerId)
                                  ->where('job_id', $jobId)
                                  ->first();

                if ($match) {
                    if ($action == 'like') {
                        $match->freelancer_status = 'like';
                        if ($match->job_status == 'like') {
                            $match->status = 'match';
                        }else{
                            $match->delete();
                        return response()->json(['status' => 'deleted']);
                        }
                    } elseif ($action == 'dislike') {
                        $match->freelancer_status = 'dislike';
                        $match->delete();
                        return response()->json(['status' => 'deleted']);
                    }
                    $match->save();
                } else {
                    ListMatch::create([
                        'freelancer_id' => $freelancerId,
                        'job_id' => $jobId,
                        'freelancer_status' => $action,
                        'status' => null,
                    ]);
                }

                
            } elseif ($user->role_id == 2) {
                // Employer swipe action
                $match = ListMatch::where('freelancer_id', $freelancerId)
                                  ->where('job_id', $jobId)
                                  ->first();

                if ($match) {
                    if ($action == 'like') {
                        $match->job_status = 'like';
                        if ($match->freelancer_status == 'like') {
                            $match->status = 'match';
                        } elseif ($match->freelancer_status == 'dislike') {
                            $match->delete();
                            return response()->json(['status' => 'deleted']);;
                        }
                    } elseif ($action == 'dislike') {
                        $match->job_status = 'dislike';
                        $match->delete();
                        return response()->json(['status' => 'deleted']);
                    }
                    $match->save();
                } else {
                    ListMatch::create([
                        'freelancer_id' => $freelancerId,
                        'job_id' => $jobId,
                        'job_status' => $action,
                        'status' => null,
                    ]);
                }

            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // Log::error('Error in swipe action', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString()
            // ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function checkSwipeLimit(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            $today = now()->toDateString();

            $swipeLimitReached = false;
            $limit = 0;

            if ($user->plan == 'Free') {
                $limit = 15;
            } elseif ($user->plan == 'Business') {
                $limit = 50;
            } elseif ($user->plan == 'Professional') {
                $limit = PHP_INT_MAX; // No limit for Professional
            }

            if ($user->swipe_date == $today && $user->swipe_count >= $limit) {
                $swipeLimitReached = true;
            }

            if ($swipeLimitReached) {
                return response()->json(['status' => 'error', 'message' => 'You have reached your swipe limit for today.']);
            } else {
                return response()->json(['status' => 'success', 'message' => 'You can swipe.']);
            }
        } catch (\Exception $e) {
            // Log::error('Error in checking swipe limit', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString()
            // ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
