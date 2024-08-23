<?php

namespace Drupal\sinratoPages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Drupal\search_api\Entity\Index;
use Drupal\search_api\SearchApiException;

class FindController extends ControllerBase {

  public function index(Request $request) {
    $search_query = $request->query->get('search', '');
    $per_page = (int)$request->query->get('per_page', 10);
    $sort_by = $request->query->get('sort_by', 'relevance');
    $page = max(1, (int)$request->query->get('page', 1));

    try {
      $index = Index::load('product_index');
      if (!$index) {
        throw new \Exception('Search index "product_index" not found.');
      }

      $query = $index->query();
      $query->keys($search_query);

      // Apply sorting
      switch ($sort_by) {
        case 'name_asc':
          $query->sort('title', 'ASC');
          break;
        case 'name_desc':
          $query->sort('title', 'DESC');
          break;
        case 'price_asc':
          $query->sort('field_price', 'ASC');
          break;
        case 'price_desc':
          $query->sort('field_price', 'DESC');
          break;
        // Add more sorting options as needed
      }

      // Set items per page and pagination
      $query->range(($page - 1) * $per_page, $per_page);

      $results = $query->execute();
      $total_items = $results->getResultCount();
    } catch (\Exception $e) {
      return new Response('An error occurred while searching: ' . $e->getMessage());
    }

    // Process and store the results
    $products = [];
    foreach ($results->getResultItems() as $result_item) {
      $entity = $result_item->getOriginalObject()->getValue();
      if ($entity) {
        $products[] = [
          'id' => $entity->id(),
          'title' => $entity->get('title')->value,
          'brand' => $entity->get('field_brand')->value,
          // Add more fields as needed
        ];
      }
    }

    $total_pages = ceil($total_items / $per_page);
    $showing_from = ($page - 1) * $per_page + 1;
    $showing_to = min($page * $per_page, $total_items);

    return [
      '#theme' => 'find',
      '#data' => [
        'search_query' => $search_query,
        'laptops' => $products,
        'per_page' => $per_page,
        'sort_by' => $sort_by,
        'current_page' => $page,
        'total_pages' => $total_pages,
        'total_items' => $total_items,
        'showing_from' => $showing_from,
        'showing_to' => $showing_to,
      ],
    ];
  }
}
