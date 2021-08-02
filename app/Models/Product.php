<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
  use HasFactory;

  protected $fillable = [
    'name',
    'desc',
    'img',
    'price',
    'stock',
    'category_id',
  ];

  public function category() {
    return $this->belongsTo(Category::class);
  }

  public function ratings() {
    return $this->hasMany(Rating::class);
  }

  public function comments() {
    return $this->hasMany(Comment::class)->orderBy('id', 'DESC');
  }

  public function carts() {
    return $this->hasMany(Cart::class);
  }
}
