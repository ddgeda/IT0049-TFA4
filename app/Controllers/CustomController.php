<?php

namespace App\Controllers;

class CustomController extends BaseController
{
    public function index()
    {
        // This loads the view file we just created in Step 1
        return view('hello');
    }
}