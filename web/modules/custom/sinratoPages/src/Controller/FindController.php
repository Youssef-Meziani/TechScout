<?php

namespace Drupal\sinratoPages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Drupal\search_api\Entity\Index;
use Drupal\search_api\SearchApiException;

class FindController extends ControllerBase {

  public function index(Request $request) {
    // Retrieve the search query from the URL.
    $search_query = $request->query->get('search', '');

    // Perform the search using Search API.
    try {
      $index = Index::load('product_index');
      if (!$index) {
        throw new \Exception('Search index "product_index" not found.');
      }

      $query = $index->query();
      $query->keys($search_query);

      $results = $query->execute();
    } catch (\Exception $e) {
      // Handle the exception.
      return new Response('An error occurred while searching: ' . $e->getMessage());
    }

    // Process and store the results.
    $products = [];
    foreach ($results->getResultItems() as $result_item) {
      $entity = $result_item->getOriginalObject()->getValue();
      if ($entity) {
        $products[] = [
          'id' => $entity->id(),
          'title' => $entity->get('title')->value,
          //'price' => $entity->get('field_price')->value,
          'brand' => $entity->get('field_brand')->value,
        ];
      }
    }

    return [
      '#theme' => 'find',
      '#data' => [
        'search_query' => $search_query,
        'laptops' => $products,
      ],
    ];
  }
}
