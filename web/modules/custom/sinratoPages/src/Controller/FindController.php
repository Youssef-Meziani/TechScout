<?php

namespace Drupal\sinratoPages\Controller;

use Drupal\Core\Controller\ControllerBase;

class FindController extends ControllerBase {

  public function index() {
    return [
      '#theme' => 'find',
      '#data' => 'This is a test var',
    ];
  }

}
