<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\School;
use App\Models\SchoolType;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Dotenv\Util\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SchoolController extends Controller
{
    //
    public function createSchoolLocation(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'email1' => 'required',
            'phone1' => 'required',
            'lng' => 'required',
            'lat' => 'required',
            'school_type_id' => 'required',
        ]);
        $response = [];
        $code = 0;

        $school_type = SchoolType::find($fields['school_type_id']);
        if ($school_type) {
            if ($this->checkEmail($fields['email1'])) {
                if ($this->checkContact($fields['phone1'])) {

                    $fields += [
                        'user_id' => Auth::user()->id
                    ];

                    $email = $fields['email1'];
                    $name = $fields['name'];

                    try {
                        $school = School::create($fields);
                        $body = "Your school location account has been created successfully!!";
                        $subject = "school location";
                        SendEmailJob::dispatch($subject, $body, $email, $name);

                        $response = [
                            'data' => $school,
                            'message' => "school location created successfully"
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
                    $response = ['message' => "This contact is already in use"];
                    $code = 422;
                }
            } else {
                $response = ['message' => "This email address is already in use"];
                $code = 422;
            }
        } else {
            $response = ['message' => "School type does not exist."];
            $code = 422;
        }

        return response($response, $code);
    }


    public function checkEmail($email)
    {
        if (School::where('email1', $email)->count() == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkContact($contact)
    {
        if (School::where('phone1', $contact)->count() == 0) {
            return true;
        } else {
            return false;
        }
    }
    public function listLocations()
    {

        $response = [];
        $code = 0;

        try {
            //code...
            $school = School::with(['school_type', 'teacher'])->get();

            $response = [
                'data' => $school,
                'message' => "Success"
            ];
            $code = 200;
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'error' => $th->getMessage(),
                'message' => "Server Error"
            ];
            $code = 500;
        }

        return response($response, $code);
    }

    public function activeUserListLocations(){

        $response = [];
        $code = 0;

        try {
            //code...
            $school = School::where('user_id', Auth::user()->id)->with(['school_type', 'teacher'])->get();

            $response = [
                'data' => $school,
                'message' => "Success"
            ];
            $code = 200;
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'error' => $th->getMessage(),
                'message' => "Server Error"
            ];
            $code = 500;
        }

        return response($response, $code);

    }
    public function locationInformation($id)
    {

        $response = [];
        $code = 0;

        try {
            //code...
            $school = School::with(['school_type', 'teacher'])->find($id);
            if ($school) {
                $response = [
                    'data' => $school,
                    'message' => "Success"
                ];
                $code = 200;
            } else {
                $response = [
                    'message' => "school do not exist"
                ];
                $code = 422;
            }
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'error' => $th->getMessage(),
                'message' => "Server Error"
            ];
            $code = 500;
        }

        return response($response, $code);
    }


    public function listSchoolLocations($user_id)
    {

        $response = [];
        $code = 0;

        $user = User::find($user_id);
        if ($user) {
            try {
                //code...

                $school = School::where('user_id', $user_id)->with(['school_type', 'teacher'])->get();
                $response = [
                    'data' => $school,
                    'message' => "Success"
                ];
                $code = 200;
            } catch (\Throwable $th) {
                //throw $th;
                $response = [
                    'error' => $th->getMessage(),
                    'message' => "Server Error"
                ];
                $code = 500;
            }
        } else {
            $response = ['message' => "Undefined user"];
            $code = 422;
        }

        return response($response, $code);
    }



    public function changeSchoolLocationStatus($id, $status)
    {
        $response = [];
        $code = 0;
        if ($status == "inactive" || $status == "active" || $status == "pending") {
            $schoolLocation = School::find($id);
            if ($schoolLocation) {
                try {
                    //code...
                    $schoolLocation->status = $status;
                    $schoolLocation->save();
                    SendEmailJob::dispatch("School Status", "your account has been $status", $schoolLocation->email, $schoolLocation->name);

                    $response = ['message' => "Status Changed successfully"];
                    $code = 200;
                } catch (\Throwable $th) {
                    //throw $th;
                    $response = [
                        'error' => $th->getMessage(),
                        'message' => "Server Error"
                    ];
                    $code = 500;
                }
            } else {
                $response = ['message' => "School location does not exist"];
                $code = 422;
            }
        } else {
            $response = ['message' => "Incorrect Status"];
            $code = 422;
        }
        return response($response, $code);
    }

    public function deleteSchoolLocation($id)
    {
        $response = [];
        $code = 0;
        $schoolLocation = School::find($id);
        if ($schoolLocation) {
            try {
                //code...
                School::where('id', $id)->delete();
                $response = ['message' => "School location deleted successfully"];
                $code = 200;
            } catch (\Throwable $th) {
                //throw $th;
                $response = [
                    'error' => $th->getMessage(),
                    'message' => "Server Error"
                ];
                $code = 500;
            }
        } else {
            $response = ['message' => "School location does not exist"];
            $code = 422;
        }
        return response($response, $code);
    }
}
