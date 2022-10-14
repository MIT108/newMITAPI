<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    //
    public function add(Request $request){
        $fields = $request->validate([
            'name' => 'required|file',
            'classe_id' => 'required'
        ]);
        // dd($request);
        $response = [];
        $code = 0;

        if (Classe::find($fields['classe_id'])) {
            if ($this->checkSubject($fields['name'], $fields['classe_id'])) {
                try {
                    //code...
                    $subject = Subject::create($fields);
                    $response = [
                        'data' => $subject,
                        'message' => 'successful'
                    ];
                    $code = 200;

                } catch (\Throwable $th) {
                    //throw $th;
                    $response = [
                        'error' => $th->getMessage(),
                        'message' => 'Internal server error'
                    ];
                    $code = 500;
                }
            } else {

                $response = [
                    'message' => 'Subject already exist'
                ];
                $code = 422;
            }
        }else{

            $response = [
                'message' => 'Classe does not exist'
            ];
            $code = 422;

        }


        return response($response, $code);
    }

    public function checkSubject($name, $classe_id){
        if (Subject::where('name', $name)->where('classe_id', $classe_id)->count() == 0) {
            return true;
        }else{
            return false;
        }
    }

    public function delete($id){
        $Subject = Subject::find($id);

        $response = [];
        $code = 0;

        if ($Subject) {
            try {

                Subject::where('id', $id)->delete();
                $response = [
                    'message' => 'successful'
                ];
                $code = 200;
            } catch (\Throwable $th) {
                //throw $th;
                //throw $th;
                $response = [
                    'error' => $th->getMessage(),
                    'message' => 'Internal server error'
                ];
                $code = 500;
            }
        } else {
            //throw $th;
            $response = [
                'message' => 'Subject not exist'
            ];
            $code = 422;

        }

        return response($response, $code);
    }
    public function list($classe_id){

        $response = [];
        $code = 0;

        try {
            //code...
            $subjects = Subject::where('classe_id', $classe_id)->get();
            $response = [
                'data' => $subjects,
                'message' => 'successful'
            ];
            $code = 200;

        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'error' => $th->getMessage(),
                'message' => 'Internal server error'
            ];
            $code = 500;
        }
        return response($response, $code);
    }
}
