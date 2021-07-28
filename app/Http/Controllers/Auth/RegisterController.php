<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class RegisterController extends Controller
{

    public function __construct(){
        $this->middleware(['guest']);
    }

    public function index(){
        return view('auth.register');
    }

    public function store(Request $request){
        // dd($request->only('email', 'password'));


        // validation
        $this->validate($request, [
            'name' => ['required', 'max:255'],
            'username' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'confirmed']
        ]);


        // store user
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);


        // sign user in
        auth()->attempt($request->only('email', 'password'));

        //Could sign in like:
        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ])
        // 
        // this is just messier and only necessary in storage phase in order to 'Hash::make' the password field

        // redirect
        return redirect()->route('dashboard');
        

        

        
    }
}
