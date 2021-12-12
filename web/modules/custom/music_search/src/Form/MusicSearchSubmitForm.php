<?php

namespace Drupal\music_search\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Media\Entity\Media;
use Drupal\file\Entity\File;

class MusicSearchSubmitForm extends FormBase



  /**
   * Class ResultForm.
   */
{
  /**
   * {@inheritdoc}
   */

  public function getFormId()
  {
    return 'results';
  }

  /**
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   * @FormElement("radios")
   * @return array|void
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $search_params = \Drupal::state()->getMultiple(['title', 'product_type']);

    if($search_params['product_type'] == 'album') {
      $api_content_type = \Drupal::service('spotify_lookup.api_service')->search_album($search_params['title']);
      $spotify_values = array();
      $options = array();
      foreach($api_content_type->albums->items as $item) {
        $spotify_values[] = $item;
        array_push($options, $item->name . '-' . $item->artists[0]->name);
        $form['results'] = [
          '#type' => 'radios',
          '#title' => 'Select Album: ',
          '#multiple' => TRUE,
          '#array' => $spotify_values,
          '#options' => $options];
        $form['results][$item][image']= [
          '#theme' => 'image',
          '#attributes' => [
            'width' => 200,
            'height' => 200,
            'style' => 'width: 200px; height: 200px;',
            'data-lazy' => TRUE,
            'src' => $item->images[1]->url,
          ]
        ];

      }
    }
    if($search_params['product_type'] == 'track') {
      $api_content_type = \Drupal::service('spotify_lookup.api_service')->search_track($search_params['title']);
      $spotify_values = array();
      $options = array();
      foreach($api_content_type->tracks->items as $item) {
        $spotify_values[] = $item;
        array_push($options, $item->name . '-' . $item->artists[0]->name);
        $form['results'] = [
          '#type' => 'radios',
          '#title' => 'Select Track: ',
          '#multiple' => TRUE,
          '#array' => $spotify_values,
          '#options' => $options];
        $form['results][$item][image']= [
          '#theme' => 'image',
          '#attributes' => [
            'width' => 200,
            'height' => 200,
            'style' => 'width: 200px; height: 200px;',
            'data-lazy' => TRUE,
            'src' => $item->album->images[1]->url,
          ]
        ];

      }
    }
    if($search_params['product_type'] == 'artist') {
      $api_content_type = \Drupal::service('spotify_lookup.api_service')->search_artist($search_params['title']);
      $spotify_values = array();
      $options = array();
      foreach($api_content_type->artists->items as $item) {
        $spotify_values[] = $item;
        array_push($options, $item->name);
        $form['results'] = [
          '#type' => 'radios',
          '#title' => 'Select Artist: ',
          '#multiple' => TRUE,
          '#array' => $spotify_values,
          '#options' => $options];
        $form['results][$item][image']= [
          '#theme' => 'image',
          '#attributes' => [
            'width' => 200,
            'height' => 200,
            'style' => 'width: 200px; height: 200px;',
            'data-lazy' => TRUE,
            'src' => $item->images[0]->url ?? NULL,
          ]
        ];
      }

    }
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => ('Submit')];



    return $form;
    // TODO: Implement buildForm() method.
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.
    \Drupal::state()->set('title', $form_state->getCompleteForm('results'));
    \Drupal::state()->set('choice_value', $form_state->getValue('results'));
    $form_state->setRedirect('music_search.choice');
  }
}
