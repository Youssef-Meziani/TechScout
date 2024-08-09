<?php

namespace Drupal\sinratoPages\Controller;

use Drupal\Core\Controller\ControllerBase;

class HomeController extends ControllerBase {

  public function index() {
    return [
      '#theme' => 'home',
      '#data' => 'This is a test var',
    ];
  }

}
