<?php

namespace Drupal\music_search\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\Form\FormStateInterface;

/**
 * @Block(
 *   id = "music_search_block",
 *   admin_label = @Translation("Music Search Block")
 * )
 */

class MusicSearchBlock extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function build() {
    // TODO: Implement build() method.
    $form = \Drupal::formBuilder()->getForm('Drupal\music_search\Form\MusicSearchForm');
    return [
      $form
    ];
  }

}
