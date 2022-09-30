<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Otp;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SendMail;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {

        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $response = [];
        $code = 0;

        try {
            //check email
            $user = User::where('email', $fields['email'])->first();

            //check password
            if (!$user || !Hash::check($fields['password'], $user->password)) {
                $response = [
                    'message' => 'Bad credentials'
                ];
                $code = 422;
            } else {
                if ($user->otp_verification == 1) {
                    if ($user->password_changed == 1) {

                        if ($user->status == "inactive") {
                            $response = [
                                'message' => 'Account is suspended'
                            ];
                            $code = 422;
                        } else {

                            $token = $user->createToken('authenticationToken')->plainTextToken;

                            $response = [
                                'data' => $user,
                                'token' => $token,
                                'message' => 'login successful'
                            ];

                            $code = 200;
                        }
                    } else {
                        $response = [
                            'message' => 'Account default password not changed',
                            'data' => $user
                        ];
                        $code = 424;
                    }
                } else {
                    $response = [
                        'message' => 'Account not verified',
                        'data' => $user
                    ];
                    $code = 423;
                }
            }
        } catch (\Throwable $th) {
            $response = [
                'error' => $th->getMessage(),
                'message' => 'Internal server error'
            ];
            $code = 500;
        }

        return response($response, $code);
    }
    public function sendOTPCode($id)
    {
        $user = User::find($id);

        $response = [];
        $code = 0;
        if ($user) {
            if ($user->otp_verification == 0) {

                try {
                    Otp::where('user_id', $user->id)->delete();
                    $code       =   rand(1000, 9999);

                    Otp::create([
                        'code' => $code,
                        'user_id' => $user->id
                    ]);
                    $body = "Your account is on verification status, enter the following code to verify your account. CODE: $code";
                    $subject = "Account OTP Verification";

                    SendEmailJob::dispatch($subject, $body, $user->email, $user->name);
                    $response = [
                        'message' => 'OTP code send successfully',
                        'data' => $user
                    ];
                    $code = 200;
                } catch (\Throwable $th) {
                    //throw $th;
                    $response = [
                        'error' => $th->getMessage(),
                        'message' => 'Internal server error contact the administrator',
                    ];
                    $code = 500;
                }
            } else {
                $response = [
                    'message' => 'Your account has been verified'
                ];
                $code = 422;
            }
        } else {
            $response = [
                'message' => 'Users does not exist'
            ];
            $code = 422;
        }

        return response($response, $code);
    }

    public function validateOTPCode($id, Request $request)
    {

        $fields = $request->validate([
            'code' => 'required',
        ]);

        $user = User::find($id);

        $response = [];
        $code = 0;
        if ($user) {
            if ($user->otp_verification == 0) {
                try {
                    if ($this->checkUserCode($id, $fields['code'])) {
                        $user->otp_verification = 1;

                        $user->save();


                        $response = [
                            'data' => $user,
                            'message' => 'successful operation'
                        ];

                        $code = 424;
                    } else {
                        $response = [
                            'message' => 'This code does not exist'
                        ];
                        $code = 422;
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                    $response = [
                        'error' => $th->getMessage(),
                        'message' => 'Internal server error contact the administrator',
                    ];
                    $code = 500;
                }
            } else {
                $response = [
                    'message' => 'Your account has been verified'
                ];
                $code = 422;
            }
        } else {
            $response = [
                'message' => 'Users does not exist'
            ];
            $code = 422;
        }

        return response($response, $code);
    }


    public function checkUserCode($user_id, $code)
    {
        if (Otp::where('user_id', $user_id)->where('code', $code)->count() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function changeUserStartupPassword(Request $request, $id)
    {

        $fields = $request->validate([
            'password' => 'required',
        ]);

        $user = User::find($id);

        $response = [];
        $code = 0;
        if ($user) {
            if($user->password_changed == 0){
                try {
                    $hashed = Hash::make($fields['password']);
                    if (Hash::needsRehash($hashed)) {
                        $hashed = Hash::make($fields['password']);
                    }
                    $user->password = $hashed;
                    $user->password_changed = 1;
                    $user->save();
    
                    $token = $user->createToken('authenticationToken')->plainTextToken;
    
                    $response = [
                        'data' => $user,
                        'token' => $token,
                        'message' => 'login successful'
                    ];
    
                    $code = 200;
                } catch (\Throwable $th) {
                    //throw $th;
                    $response = [
                        'error' => $th->getMessage(),
                        'message' => 'Internal server error contact the administrator',
                    ];
                    $code = 500;
                }

            }else{
                $response = [
                    'message' => 'User is not allowed to change his password here'
                ];
                $code = 422;

            }
        } else {
            $response = [
                'message' => 'Users does not exist'
            ];
            $code = 422;
        }
        return response($response, $code);
    }
    public function logout()
    {
        $response = [];
        $code = 0;

        try {
            //code...
            auth()->user()->tokens()->delete();
            $response = [
                'message' => 'logout successful'
            ];
            $code = 200;
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'error' => $th->getMessage(),
                'message' => 'logout error'
            ];
            $code = 500;
        }

        return response($response, $code);
    }

    public function create(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'user_name' => 'required',
            'role_id' => 'required',
            'contact' => 'required',
        ]);
        $response = [];
        $code = 0;

        $role = Role::find($fields['role_id']);
        if ($role) {
            if ($this->checkEmail($fields['email'])) {
                if ($this->checkContact($fields['contact'])) {

                    if ($this->checkUserName($fields['user_name'])) {
                        $fields += [
                            'password' => Str::random(8)
                        ];
                        // $hashed = Hash::make($fields['password']);
                        $hashed = Hash::make('password');
                        // if (Hash::needsRehash($hashed)) {
                        //     $hashed = Hash::make($fields['password']);
                        // }

                        $fields += [
                            'creator_id' => Auth::user()->id
                        ];
                        $fields += [
                            'country_id' => Auth::user()->country_id
                        ];
                        $password = $fields['password'];
                        $email = $fields['email'];
                        $name = $fields['name'];
                        $fields['password'] = $hashed;

                        try {
                            $school = User::create($fields);
                            $body = "Your $role->name account has been created successfully!! your credentials are  __ Email: $email __ Password: $password";
                            $subject = "$role->name Account";
                            SendEmailJob::dispatch($subject, $body, $email, $name);

                            $response = [
                                'message' => "$role->name created successfully"
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
                        $response = ['message' => "This username is already in use"];
                        $code = 422;
                    }
                } else {
                    $response = ['message' => "This contact is already in use"];
                    $code = 422;
                }
            } else {
                $response = ['message' => "This email address is already in use"];
                $code = 422;
            }
        } else {
            $response = ['message' => "Role does not exist."];
            $code = 422;
        }

        return response($response, $code);
    }


    public function checkEmail($email)
    {
        if (User::where('email', $email)->count() == 0) {
            return true;
        } else {
            return false;
        }
    }


    public function checkUserName($username)
    {
        if (User::where('user_name', $username)->count() == 0) {
            return true;
        } else {
            return false;
        }
    }
    public function checkContact($contact)
    {
        if (User::where('contact', $contact)->count() == 0) {
            return true;
        } else {
            return false;
        }
    }
}
