<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    $carts = Cart::where('user_id', auth()->user()->id)->get();
    $totalPrice = 0;

    foreach ($carts as $cart) {
      $totalPrice += $cart->product->price * $cart->count;
    }

    return view('cart.index', [
      'carts' => $carts,
      'totalPrice' => $totalPrice,
    ]);
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
    $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $request->data['product_id'])->first();

    if ($cart) {
      return response($cart);
    }

    $product_id = $request->data['product_id'];
    $user_id = auth()->user()->id;
    $count = $request->data['currentQuantity'];

    $cart = new Cart;

    $cart->user_id = $user_id;
    $cart->product_id = $product_id;
    $cart->count = $count;

    $cart->save();

    return response($cart);
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
    $cart = Cart::find($id);

    if (auth()->user()->cannot('update', $cart)) {
      return response(['message' => 'Unauthorized access!'], 401);
    }

    $cart->count = $request->newQuantity;
    $cart->save();

    return response($cart);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {
    $cart = Cart::find($id);

    if (auth()->user()->cannot('delete', $cart)) {
      return response(['message' => 'Unauthorized access!'], 401);
    }

    $cart->delete();

    return response($cart);
  }

  public function destroy2($id) {
    $cart = Cart::find($id);

    if (auth()->user()->cannot('delete', $cart)) {
      return back()->with('unauthorized', 'Unauthorized access!');
    }

    $cart->delete();

    return back()->with('delete_cart_success', 'Product removed from cart successfully!');
  }
}
