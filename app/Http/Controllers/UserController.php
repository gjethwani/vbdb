<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\User;

class UserController extends Controller
{
    public function login() {
      $toAdd = new User;
      $toAdd->username = 'neerav';
      $toAdd->password = 'larein';
    //  $toAdd->save();
      return view('login');
    }

    public function authenticateUser(Request $request) {
      $username = $request->input('username');
      $password = $request->input('password');
      $validation = Validator::make($request->all(),[
          'username' => 'required',
          'password' => 'required'
      ]);
      if ($validation->passes()) {
        //get all values for auto complete and return inventory view
        $user = User::find($username);
        if (!$user) {
          return redirect('/vbdb/login')
              ->withInput()
              ->withErrors(['No such user']);
        }
        Auth::login($user);
        if ($user->password == $password) {
          return redirect('vbdb/inventory');
        } else {
          return redirect('/vbdb/login')
              ->withInput()
              ->withErrors(['Invalid login credentials']);
        }

      } else {
          return redirect('/vbdb/login')
              ->withInput()
              ->withErrors($validation);
      }
    }
}
