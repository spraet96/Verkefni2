<?php

namespace Drupal\music_search\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\spotify_lookup\SpotifyLookup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class MusicSearchForm.
 */

class MusicSearchForm extends FormBase{
  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'music_search'; // TODO: Implement getFormId() method.

  }

  /**
   * {@inheritdoc}
   */
  /**
   * @param array $form
   * @param FormStateInterface $form_state
   * @return array
   * @FormElement("radios")
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['Search'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search'),
      '#description' =>$this->t('Search...'),
    ];
    $form['types'] = [
      '#type' => 'radios',
      '#title' => $this->t('Chose Track, Artist or Album.'),
      '#default_value' => 'track',
      '#options' => array(
        'track' => $this -> t('Track'),
        'artist' => $this -> t('Artist'),
        'album' => $this -> t('Album'),
      )
    ];
    $content_type = $form_state->getValue('types');

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];


    return $form;

  }


  /**
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    \Drupal::state()->setMultiple(['title' => $form_state->getValue('Search'), 'product_type' => $form_state->getValue('types')]);
     $form_state->setRedirect('music_search.submit');
    // TODO: Implement submitForm() method.
  }
}
