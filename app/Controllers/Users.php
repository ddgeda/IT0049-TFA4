<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        
        // Fetch records from the database instead of a static array
        $data['users'] = $userModel->findAll();

        return view('users_view', $data); // Adjust view name to match your TFA1 view
    }
}