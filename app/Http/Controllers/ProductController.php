<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    // $products = DB::select("SELECT *, COUNT(p.id) AS NUM_OF_COMMENTS FROM `products` p JOIN `comments` c ON p.id = c.product_id GROUP BY p.id, c.product_id ORDER BY NUM_OF_COMMENTS");
    $products = Product::all();
    $mostCommentedProductsV = mostCommentedProducts($products);
    $mostCommentedProductsV = $mostCommentedProductsV->slice(0, 10);

    return view('index', [
      'products' => $products,
      'mostCommentedProducts' => $mostCommentedProductsV,
    ]);
  }
}
