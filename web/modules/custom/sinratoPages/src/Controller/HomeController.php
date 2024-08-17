<?php

namespace Drupal\sinratoPages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class HomeController extends ControllerBase {

  public function index() {
    $connection = Database::getConnection();

    $query = $connection->select('commerce_product__field_brand', 'fb');
    $query->fields('fb', ['field_brand_value']);
    $query->addExpression('COUNT(fb.entity_id)', 'laptop_count');
    $query->groupBy('fb.field_brand_value');

    $results = $query->execute()->fetchAllKeyed();

    return [
      '#theme' => 'home',
      '#data' => [
        'brands' => $results,
      ],
    ];
  }

}
