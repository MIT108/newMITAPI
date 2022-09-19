<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\TeachersImport;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Models\School;

class TeacherController extends Controller
{
    //
    public function uploadTeacherExcel(Request $request){
        $fields = $request->validate([
            'file' => 'required|file',
            'schoolId' => 'required'
        ]);
        // dd($request);
        $response = [];
        $code = 0;
        try {
            //code...
            $school = School::find($fields['schoolId']);
            if($school){
                Excel::import(new UsersImport(), $request->file);

                Excel::import(new TeachersImport($school), $request->file);


                // $file = fopen($request->file->getRealPath(), 'r');

                // while ($row = fgetcsv($file)) {
                // dd($file[1]);
                // // User::create([
                //     //     'name' => $row['name'],
                //     //     'email' => $row['email'],
                //     //     'user_name' => $row['user_name'],
                //     //     'role_id' => 2,
                //     //     'country_id' => 1,
                //     //     'password' => Hash::make("password"),
                //     //     'contact' => $row['contact'],
                //     // ]);
                // }

                $response = [
                    'message' => 'Successful file upload'
                ];
                $code = 200;

            }else{
                $response = [
                    'message' => 'School do not exist'
                ];
                $code = 422;

            }
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'error' => $th->getMessage(),
                'message' => 'Server error'
            ];
            $code = 500;
        }
        return response($response, $code);
    }
}
