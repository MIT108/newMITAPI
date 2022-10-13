<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function testWebsocket(){
        event(new TestEvent());
        dd("hello");
    }
}
