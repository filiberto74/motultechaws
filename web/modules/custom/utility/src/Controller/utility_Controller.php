<?php
/**
 * @file
 * Contains \Drupal\utility\Controller\utility_Controller.
 */
namespace Drupal\utility\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\Core\Uri;
use Symfony\Component\HttpFoundation\RedirectResponse;

class utility_Controller extends ControllerBase {
  
  public function clear_cache() {
    drupal_flush_all_caches();
    $referer = $_SERVER['HTTP_REFERER'] ?? null;
    \Drupal::messenger()->addStatus('All caches cleared.');
    return new RedirectResponse($referer);
  }  
}