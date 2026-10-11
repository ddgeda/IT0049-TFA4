<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function attemptLogin()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user && isset($user['password']) && is_string($password) && password_verify($password, $user['password'])) {
            $session->regenerate(true);
            $session->set([
                'id'         => $user['id'],
                'username'   => $user['username'],
                'isLoggedIn' => true,
            ]);
            return redirect()->to('/customers');
        }

        return redirect()->back()->with('error', 'Invalid username or password.');
    }

    // --- ADD THESE TWO METHODS FOR SIGN-UP ---

    public function signup()
    {
        return view('signup');
    }

    public function attemptSignup()
    {
        $model = new \App\Models\UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            // Securely hash the password before inserting into the database
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        $model->save($data);

        return redirect()->to('/login')->with('success', 'Account created successfully! Please sign in.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
    
}