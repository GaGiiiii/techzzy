<?php

function mostCommentedProducts($products) {
  for ($i = 0; $i < sizeof($products) - 1; $i++) {
    for ($j = $i + 1; $j < sizeof($products); $j++) {
      $numberOfCommentsI = sizeof($products[$i]->comments);
      $numberOfCommentsJ = sizeof($products[$j]->comments);

      if ($numberOfCommentsJ > $numberOfCommentsI) {
        $help = $products[$i];
        $products[$i] = $products[$j];
        $products[$j] = $help;
      }
    }
  }

  return $products;
}

function calculateRatingForProduct($product) {
  if (sizeof($product->ratings) == 0) {
    return 0.0;
  }

  $total = 0.0;

  foreach ($product->ratings as $rating) {
    $total += $rating->rating;
  }

  return round($total / sizeof($product->ratings), 2);
}

function formatDate($date) {
  return date("d/m/Y H:m", strtotime($date));
}

function findRatingForProductFromUser($user, $product) {
  foreach ($user->ratings as $rating) {
    if ($rating->product_id == $product->id) {
      return $rating->rating;
    }
  }

  return 0;
}
