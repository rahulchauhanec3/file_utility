<?php

namespace Drupal\file_utility\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Defines a route for device model entity autocomplete form elements.
 */
class FileUtilityController extends ControllerBase {

  public function downloadaction() {
    global $base_url;
    if (!isset($_GET['f'])) {
      return;
    }
    // Process download
    $full_path = $base_url.'/'.$_GET['f'];

      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="'.basename($full_path).'"');
      header('Expires: 0');
      header('Content-Transfer-Encoding: binary');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($full_path));
      flush(); // Flush system output buffer
      readfile($full_path);
      die;
  }
}
