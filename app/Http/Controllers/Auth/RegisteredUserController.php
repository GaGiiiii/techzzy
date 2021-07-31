<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller {
  /**
   * Display the registration view.
   *
   * @return \Illuminate\View\View
   */
  public function create() {
    return view('auth.register');
  }

  /**
   * Handle an incoming registration request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request) {
    $request->validate([
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'username' => 'required|string|max:255|unique:users',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
      'img' => 'file|image|max:5000'
    ]);

    // CREATE UNIQUE FILENAME AND STORE IT UNIQUE FOLDER
    if (isset($request->img)) {
      $fileName = $request->username . "_" . date('dmY_Hs') . "." . $request->img->extension() ?? null;
      $path = $request->file('img')->storeAs('avatars/' . $request->username, $fileName);
    } else {
      $fileName = 'no_image.png';
    }

    $user = User::create([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'username' => $request->username,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'img' => $fileName,
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect(RouteServiceProvider::HOME)->with('register_successful', "Welcome: " . auth()->user()->username . ", this is your dashboard page. You can edit your profile data here.");
  }
}
