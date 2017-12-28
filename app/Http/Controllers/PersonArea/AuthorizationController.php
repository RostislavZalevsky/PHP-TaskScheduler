<?php

namespace App\Http\Controllers\PersonArea;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Cookie;
use Illuminate\Http\Response;

class AuthorizationController extends Controller
{
    public function Authorization(Request $request)
    {
        if($this->LoginAccount($request->input('email'), $request->input('password')))
            return redirect('/');
        else return view('personal_area', ['Invalid'=>'Invalid Email or Password']);
    }

    public static function LoginAccount($Email, $Password)
    {
        $table = DB::table('Users')->where('Email', $Email)->first();

        if($table!=null && password_verify($Password, $table->Password))
        {
            $selector = base64_encode(random_bytes(9));
            $authenticator = random_bytes(33);

            $values = array($selector, base64_encode($authenticator));

            setcookie('Account', json_encode($values),time() + 2592000);

            DB::table('AuthTokens')->insert([
                'Selector' => $selector,
                'Token' => hash('sha256', $authenticator),
                'UserId' => $table->Id,
                'Expires' => date('Y-m-d\TH:i:s', time() + 2592000)
            ]);


            return true;
        }
        return false;
    }

    public static function VerifyAccount()
    {
        if(!isset($_COOKIE["Account"])) return false;
        $value = json_decode($_COOKIE["Account"]);
        $selector = $value[0];
        $authenticator = $value[1];

        $AuthToken = DB::table('AuthTokens')->where('Selector', $selector)->first();

        if ($AuthToken != null && hash_equals($AuthToken->Token, hash('sha256', base64_decode($authenticator))))
        {
            $_SESSION['UserId'] = $AuthToken->UserId;
            return true;
        }
        return false;
    }

    public function LogoutAccount()
    {
        unset($_COOKIE["Account"]);
        setcookie('Account', null, -1);

        return redirect('/');
    }
}
