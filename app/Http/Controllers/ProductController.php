<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    $products = Product::all()->take(20);

    // OPTION ONE
    $mostCommentedProductsV = mostCommentedProducts($products);
    $mostCommentedProductsV = $mostCommentedProductsV->slice(0, 20);

    // OPTION TWO
    $mostLikedProductsV = DB::select("SELECT * FROM `products` p JOIN
    (SELECT r.product_id, AVG(r.rating) AS RATING FROM `ratings` r GROUP BY r.product_id) t2 ON p.id = t2.product_id ORDER BY t2.RATING DESC");

    $mostLikedProductsV = array_slice($mostLikedProductsV, 0, 20);

    return view('index', [
      'products' => $products,
      'mostCommentedProducts' => $mostCommentedProductsV,
      'mostLikedProducts' => $mostLikedProductsV,
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id) {
    $product = Product::find($id);

    if (!$product) {
      abort(404);
    }

    $usersRating = 0;

    foreach($product->ratings as $rating){
      if($rating->user_id == auth()->user()->id){
        $usersRating = $rating->rating;

        break;
      }
    }

    $cartForUserForThisProduct = Cart::where('user_id', auth()->user()->id)->where('product_id', $id)->first();

    return view('products.show', [
      'product' => $product,
      'usersRating' => $usersRating,
      'cartForUserForThisProduct' => $cartForUserForThisProduct,
    ]);
  }
}
