<?php

namespace App\Http\Controllers\PersonArea;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Http\Controllers\PersonArea\AuthorizationController;

class RegistrationController extends Controller
{
    public function Registration(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|unique:Users,Email',
            'password' => 'required|min:6|max:20|confirmed',//|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
            //'password_confirmation' => 'same:password',
        ]/*,[
            //'password_confirmation.required' => ' The confirm password field is required.',
            //'password_confirmation.same' => ' The confirm password and password must match. ',
        ]*/);

        DB::table('Users')->insert([
            'Email' => $request->input('email'),
            'Password' => bcrypt($request->input('password_confirmation')),
        ]);

        AuthorizationController::LoginAccount($request->input('email'), $request->input('password_confirmation'));

        return redirect('/');
    }
}
