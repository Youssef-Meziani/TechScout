<?php

namespace Drupal\sinratoPages\Controller;

use Drupal\Core\Controller\ControllerBase;

class LaptopController extends ControllerBase {

  public function index() {
    return [
      '#theme' => 'laptop',
      '#data' => 'This is a test var',
    ];
  }

}
