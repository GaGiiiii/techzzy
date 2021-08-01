<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory {
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Product::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition() {
    $categories = Category::all();

    return [
      'name' => $this->faker->firstName(),
      'desc' => $this->faker->text(100),
      'img' => 'no_image.png',
      'price' => rand(1000 * 100, 100000 * 100) / 100,
      'stock' => rand(0, 100),
      'category_id' => $categories[rand(0, sizeof($categories) - 1)],
    ];
  }
}
