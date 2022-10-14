<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\School;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    //
    public function add(Request $request){
        $fields = $request->validate([
            'name' => 'required|file',
            'school_id' => 'required'
        ]);
        // dd($request);
        $response = [];
        $code = 0;

        if (School::find($fields['school_id'])) {
            if ($this->checkClasse($fields['name'], $fields['school_id'])) {
                try {
                    //code...
                    $class = Classe::create($fields);
                    $response = [
                        'data' => $class,
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
                    'message' => 'Class already exist'
                ];
                $code = 422;
            }
        }else{
            $response = [
                'message' => 'School does not exist'
            ];
            $code = 422;

        }


        return response($response, $code);
    }

    public function checkClasse($name, $school_id){
        if (Classe::where('name', $name)->where('school_id', $school_id)->count() == 0) {
            return true;
        }else{
            return false;
        }
    }

    public function delete($id){
        $classe = Classe::find($id);

        $response = [];
        $code = 0;

        if ($classe) {
            try {

                Classe::where('id', $id)->delete();
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
                'message' => 'class not exist'
            ];
            $code = 422;

        }

        return response($response, $code);
    }

    public function list($school_id){

        $response = [];
        $code = 0;

        try {
            //code...
            $classes = Classe::where('school_id', $school_id)->get();
            $response = [
                'data' => $classes,
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
