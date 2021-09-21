<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
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
    $allProducts = Product::all();

    // OPTION ONE
    $mostCommentedProductsV = mostCommentedProducts($allProducts);
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
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index2(Request $request) {
    $sortType = $request->query('sort') ?? 'name';
    $priceRange = $request->query('price') ?? 500000;
    $categoriesQueryParams = $request->query('categories') ?? null;
    $arrayOfIDs = [];

    if (isset($categoriesQueryParams)) {
      $categoriesQueryParams = explode(",", $categoriesQueryParams);

      // Need to find ID's based on category names
      $categoryModels = Category::select('id')->whereIn('name', $categoriesQueryParams)->get()->toArray();

      foreach ($categoryModels as $categoryModel) {
        array_push($arrayOfIDs, $categoryModel['id']);
      }
    }

    switch ($sortType) {
      case 'price':
        if (!empty($arrayOfIDs)) {
          $products = Product::where('price', '<', $priceRange)->whereIn('category_id', $arrayOfIDs)->orderBy($sortType, "DESC")->paginate(16);
        } else {
          $products = Product::where('price', '<', $priceRange)->orderBy($sortType, "DESC")->paginate(16);
        }
        break;
      case 'price2':
        if (!empty($arrayOfIDs)) {
          $products = Product::where('price', '<', $priceRange)->whereIn('category_id', $arrayOfIDs)->orderBy('price', "ASC")->paginate(16);
        } else {
          $products = Product::where('price', '<', $priceRange)->orderBy('price', "ASC")->paginate(16);
        }
        break;
      case 'name':
        if (!empty($arrayOfIDs)) {
          $products = Product::where('price', '<', $priceRange)->whereIn('category_id', $arrayOfIDs)->orderBy($sortType)->paginate(16);
        } else {
          $products = Product::where('price', '<', $priceRange)->orderBy($sortType)->paginate(16);
        }
        break;
      case 'comments':
        if (!empty($arrayOfIDs)) {
          $products = mostCommentedProducts(Product::where('price', '<', $priceRange)->whereIn('category_id', $arrayOfIDs)->get());
        } else {
          $products = mostCommentedProducts(Product::where('price', '<', $priceRange)->get());
        }
        $products = paginate($products, 16, null, ['path' => 'http://localhost:8000/products']);
        break;
      case 'ratings':
        if (!empty($arrayOfIDs)) {
          $products = mostLikedProducts(Product::where('price', '<', $priceRange)->whereIn('category_id', $arrayOfIDs)->get());
        } else {
          $products = mostLikedProducts(Product::where('price', '<', $priceRange)->get());
        }
        $products = paginate($products, 16, null, ['path' => 'http://localhost:8000/products']);
        break;
      default:
        if (!empty($arrayOfIDs)) {
          $products = Product::where('price', '<', $priceRange)->whereIn('category_id', $arrayOfIDs)->orderBy('name')->paginate(16);
        } else {
          $products = Product::where('price', '<', $priceRange)->orderBy('name')->paginate(16);
        }
    }

    $categories = Category::all();

    return view('products.index', [
      'products' => $products,
      'categories' => $categories,
      'categoriesQueryParams' => $categoriesQueryParams,
      'sortType' => $sortType,
      'priceRange' => $priceRange,
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

    $usersRating = null;

    if (auth()->user()) {
      foreach ($product->ratings as $rating) {
        if ($rating->user_id == auth()->user()->id) {
          $usersRating = $rating;

          break;
        }
      }

      $cartForUserForThisProduct = Cart::where('user_id', auth()->user()->id)->where('product_id', $id)->first();
    }


    return view('products.show', [
      'product' => $product,
      'usersRating' => $usersRating,
      'cartForUserForThisProduct' => $cartForUserForThisProduct ?? null,
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request) {
    $enteredText = $request->data['enteredText'];
    // $products = Product::where('name', 'like', "%$enteredText%")->get();
    $products = DB::select("SELECT *, p.name AS product_name, p.id AS product_id FROM `products` p 
    JOIN `categories` c ON c.id = p.category_id
    JOIN (SELECT r.product_id, AVG(r.rating) AS RATING FROM `ratings` r GROUP BY r.product_id) t2 ON p.id = t2.product_id
    WHERE p.name LIKE '%$enteredText%'");

    // JOIN (SELECT r.product_id, AVG(r.rating) AS RATING FROM `ratings` r GROUP BY r.product_id) t2 ON p.id = t2.product_id

    // $mostLikedProductsV = DB::select("SELECT * FROM `products` p JOIN
    // -- (SELECT r.product_id, AVG(r.rating) AS RATING FROM `ratings` r GROUP BY r.product_id) t2 ON p.id = t2.product_id ORDER BY t2.RATING DESC");

    return $products;
  }
}
