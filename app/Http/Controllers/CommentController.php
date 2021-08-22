<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller {
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
    if ($request->user_id != auth()->user()->id) {
      return back()->with('unauthorized', 'Unauthorized access!');
    }

    $product = Product::find($request->product_id);

    if (!$product) {
      return back()->with('unauthorized', 'Unauthorized access!');
    }

    // VALIDATE DATA
    $validated = $request->validate([
      'body' => 'required|min:20',
    ]);

    $comment = new Comment;

    $comment->body = $request->body;
    $comment->user_id = $request->user_id;
    $comment->product_id = $request->product_id;

    $comment->save();

    return back()->with('add_comment_success', 'Comment added successfully!');
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
    $comment = Comment::find($id);

    if (!$comment) {
      return back()->with('unauthorized', 'Unauthorized access!');
    }

    if (auth()->user()->cannot('update', $comment)) {
      return response(['message' => 'Unauthorized access!'], 401);
    }

    $comment->body = $request->data;
    $comment->save();

    return response($comment);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($comment_id) {
    $comment = Comment::find($comment_id);

    if (auth()->user()->cannot('delete', $comment)) {
      return back()->with('unauthorized', 'Unauthorized access!');
    }

    $comment->delete();

    return back()->with('delete_comment_success', 'Comment deleted successfully!');
  }
}
