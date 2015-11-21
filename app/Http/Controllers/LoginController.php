<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('admin.login', ['failed' => false, 'username' => '']);
    }

    public function doLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $remember = $request->input('remember');
        if (!$username || !$password) {
            return redirect()->route('admin_login');
        }
        $admin = Admin::login($username, $password);
        if (!$admin) {
            return view('admin.login', ['failed' => true, 'username' => $username]);
        }
        $request->session()->put('admin', $username);

        return redirect()->route('admin_dashboard');
    }
}
