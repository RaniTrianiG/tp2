<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller{
  public function register(){
    return view('auth.register');
  }
  
	public function store(Request $request){
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => [
				'required', 
				'string', 
				Password::min(8)
				->mixedCase()
				->numbers()
				->symbols()
				->uncompromised(),
				'confirmed'
			],
      'password_confirmation' => 'required',
    ]);
          
		User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);
        
		return redirect('login');
  }
}