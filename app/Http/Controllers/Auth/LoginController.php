<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function login()
    {

      return view('auth.login');
    }

    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
          'email' => [
              'required',
              'email'
          ],
          'password' => [
              'required'
          ],
          'captcha' => 'required|captcha',
        ],
        ['captcha.captcha' => 'Invalid captcha code.']);

        if ($validator->fails()) {
          $errors = $validator->messages();
          return redirect('login')->with('error', 'LMAO');
        } else {
          $credentials = $request->only('email', 'password');
          if (Auth::attempt($credentials)) {
            return redirect()->intended('home');
          } else {
            return redirect('login')->with('error', 'LMAO2');
          }
        }
    }

    public function logout() {
      Auth::logout();

      return redirect('login');
    }

    public function home()
    {

      return view('auth.home');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
