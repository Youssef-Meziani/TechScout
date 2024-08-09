<?php

namespace Drupal\sinratoPages\Controller;

use Drupal\Core\Controller\ControllerBase;

class CompareController extends ControllerBase {

  public function index() {
    return [
      '#theme' => 'compare',
      '#data' => 'This is a test variable',
    ];
  }

}
