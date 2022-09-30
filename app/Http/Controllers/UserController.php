<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function changeUserStatus($user_id, $status)
    {
        $response = [];
        $code = 0;
        if ($status == "inactive" || $status == "active") {
            if ($user_id != 1) {
                $user = User::find($user_id);
                $user->status = $status;
                $user->save();
                SendEmailJob::dispatch("Account Status", "your account has been $status", $user->email, $user->name);

                $response = ['message' => "Status Changed successfully"];
                $code = 200;
            } else {
                $response = ['message' => "Cant modify admin status"];
                $code = 422;
            }
        } else {
            $response = ['message' => "Incorrect Status"];
            $code = 422;
        }
        return response($response, $code);
    }

    public function listUser($role_id)
    {
        $response = []; //
        $code = 0;
        $role = Role::find($role_id);
        if ($role) {
            try {
                $school = User::where('role_id', 3)->get();
                $response  = [
                    'data' => $school,
                    'message' => "successful"
                ];
                $code = 200;
            } catch (\Throwable $th) {
                $response = [
                    'error' => $th->getMessage(),
                    'message' => "Server Error"
                ];
                $code = 500;
            }
        } else {
            $response = ['message' => "Role does not exist"];
            $code = 422;
        }

        return response($response, $code);
    }

    public function listActiveUser($role_id)
    {
        $response = []; //
        $code = 0;
        $role = Role::find($role_id);
        if ($role) {
            try {
                $school = User::where('role_id', 3)->where('status', 'active')->get();
                $response  = [
                    'data' => $school,
                    'message' => "successful"
                ];
                $code = 200;
            } catch (\Throwable $th) {
                $response = [
                    'error' => $th->getMessage(),
                    'message' => "Server Error"
                ];
                $code = 500;
            }
        } else {
            $response = ['message' => "Role does not exist"];
            $code = 422;
        }
        return response($response, $code);
    }
    public function listInActiveUser($role_id)
    {
        $response = []; //
        $code = 0;
        $role = Role::find($role_id);
        if ($role) {
            try {
                $school = User::where('role_id', 3)->where('status', 'inactive')->get();
                $response  = [
                    'data' => $school,
                    'message' => "successful"
                ];
                $code = 200;
            } catch (\Throwable $th) {
                $response = [
                    'error' => $th->getMessage(),
                    'message' => "Server Error"
                ];
                $code = 500;
            }
        } else {
            $response = ['message' => "Role does not exist"];
            $code = 422;
        }
        return response($response, $code);
    }

    public function user($user_id){
        $response = []; //
        $code = 0;
            try {
                $user = USer::find($user_id);
                $response  = [
                    'data' => $user,
                    'message' => "successful"
                ];
                $code = 200;
            } catch (\Throwable $th) {
                $response = [
                    'error' => $th->getMessage(),
                    'message' => "Server Error"
                ];
                $code = 500;
            }
        return response($response, $code);

    }

    public function authUser(){
        $response = []; //
        $code = 0;
        try {
            $user = User::find(Auth::user()->id);
            $response  = [
                'data' => $user,
                'message' => "successful"
            ];
            $code = 200;
        } catch (\Throwable $th) {
            $response = [
                'error' => $th->getMessage(),
                'message' => "Server Error"
            ];
            $code = 500;
        }
        return response($response, $code);
    }

    public function listAccount(){
        $response = []; //
        $code = 0;
        try {
            $response  = [
                'data' => [
                    "teacher" => Teacher::where('user_id', Auth::user()->id)->with('school')->get(),
                    "student" => Teacher::where('user_id', Auth::user()->id)->with('school')->get()
                ],
                'message' => "successful"
            ];
            $code = 200;
        } catch (\Throwable $th) {
            $response = [
                'error' => $th->getMessage(),
                'message' => "Server Error"
            ];
            $code = 500;
        }
        return response($response, $code);

    }
}
