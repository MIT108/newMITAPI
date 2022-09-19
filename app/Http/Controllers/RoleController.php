<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function getRole(){
        $response = [];
        $code = 0;
        try {
            $roles = Role::get();
            $response = [
                'data' => $roles,
                'message' => 'successful'
            ];
            $code = 200;
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'error' => $th->getMessage(),
                'message' => 'error'
            ];
            $code = 500;
        }
        return response($response, $code);
    }
    public function test(){
        return "ok";
    }

    public function getCountries(){
        $response = [];
        $code = 0;
        try {
            $countries = Country::get();
            $response = [
                'data' => $countries,
                'message' => 'successful'
            ];
            $code = 200;
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'error' => $th->getMessage(),
                'message' => 'error'
            ];
            $code = 500;
        }
        return response($response, $code);
    }
}
