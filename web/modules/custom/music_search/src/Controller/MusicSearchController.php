<?php
namespace Drupal\music_search\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for music_search.
 */
class MusicSearchController extends ControllerBase {

  /**
   * Hello World
   *
   * @return array
   *  our message.
   */
  public function helloWorld() {
    return [
      '#markup' => $this->t('Hello World'),
    ];
  }
}
