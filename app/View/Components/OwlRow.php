<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OwlRow extends Component {
  /**
   * The row title.
   *
   * @var string
   */
  public $title;

  /**
   * The row type.
   *
   * @var string
   */
  public $type;

  /**
   * The row products.
   *
   * @var string
   */
  public $products;


  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($title, $products, $type) {
    $this->title = $title;
    $this->products = $products;
    $this->type = $type;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render() {
    return view('components.owl-row');
  }
}
