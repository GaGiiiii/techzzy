<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;


class UserController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id) {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id) {
    if (auth()->user()->id != $id) {
      return back()->with('unauthorized', 'Unauthorized access!');
    }

    // VALIDATE OTHER DATA
    $validated = $request->validate([
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'username' => 'required|string|max:255|unique:users,username,' . auth()->user()->id,
      'email' => 'required|string|email|max:255|unique:users,email,' . auth()->user()->id,
      'img' => 'file|image|max:5000',
      // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // CHECK IF IMAGE IS UPLOADED
    if (isset($request->img)) {
      // DELETE OLD USER PHOTO
      Storage::deleteDirectory('avatars/' .  auth()->user()->username);

      // CREATE UNIQUE FILENAME AND STORE IT UNIQUE FOLDER
      $fileName = auth()->user()->username . "_" . date('dmY_Hs') . "." . $request->img->extension() ?? null;
      $path = $request->file('img')->storeAs('avatars/' . auth()->user()->username, $fileName);
    }

    // UPDATE USERS DATA
    $user = User::find($id);

    $user->first_name = $request->input('first_name');
    $user->last_name = $request->input('last_name');
    $user->username = $request->input('username');
    $user->email = $request->input('email');
    if (!empty($request->password)) {
      $user->password = Hash::make($request->password);
    }
    if (isset($fileName)) {
      $user->img = $fileName;
    }

    $user->save();

    return back()->with('update_successful', 'Profile updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {
    //
  }
}
