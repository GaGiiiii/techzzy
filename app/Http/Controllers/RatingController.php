<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller {
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
    // IF USER CHANGED URL TO SOMETHING STUPID
    $product_id = $request->product_id;
    $product = Product::find($product_id);

    if (!$product) {
      return back()->with('unauthorized', 'Unauthorized access!');
    }

    // USER DIDN'T ALREADY RATE THIS PRODUCT SO WE CREATE NEW RATING
    $ratingSent = $request->rating;

    $rating = new Rating;
    $rating->user_id = auth()->user()->id;
    $rating->product_id = $product_id;
    $rating->rating = $ratingSent;

    $rating->save();

    return back()->with('add_rating_success', 'Rating sent successfully!');
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
    // WE NEED TO CHECK IF USER ALREADY RATED CURRENT PRODUCT, IF HE DID, WE NEED TO UPDATE IT 
    // NOT TO CREATE NEW
    $rating = Rating::find($id);

    if ($rating) {
      $rating->rating = $request->rating;
      $rating->save();

      return back()->with('add_rating_success', 'Rating sent successfully!');
    }
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
