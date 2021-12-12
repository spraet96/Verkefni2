<?php

namespace Drupal\music_search\Form;

use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Media\Entity\Media;
use Drupal\file\Entity\File;

class MusicSearchChoiceForm extends FormBase {

  /**
   * @return string
   */
  public function getFormId() {
    // TODO: Implement getFormId() method.
    return 'music_search_choice';
  }

  /**
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // TODO: Implement buildForm() method.
    $choice = \Drupal::state()->get('title');
    $choice_value = \Drupal::state()->get('choice_value');
    $my_array = $choice['results']['#array'][$choice_value];

    if ($my_array->type == "album") {
      $form['options'] = [
        '#type' => 'checkboxes',
        '#my_array' => $my_array,
        '#options' => [
          'album_name' => 'Album name: ' . $my_array->name,
          'artist_name' => 'Artist name: ' . $my_array->artists[0]->name,
          'release_date' => 'Release Date: ' . $my_array->release_date,
          'spotify_link' => 'Spotify Link: ' . $my_array->external_urls->spotify,
          'total_tracks' => 'Total album tracks: ' . $my_array->total_tracks,
        ]
      ];
      $form['images'] = [
        '#theme' => 'image',
        '#attributes' => [
          'width' => 300,
          'height' => 300,
          'style' => 'width: 300px; height: 300px;',
          'data-lazy' => TRUE,
          'src' => $my_array->images[1]->url,
        ]
      ];
    }

    if ($my_array->type == "artist") {
      $form['options'] = [
        '#type' => 'checkboxes',
        '#my_array' => $my_array,
        '#options' => [
          'artist_name' => 'Artist name: ' . $my_array->name,
          'spotify_link' => 'Spotify Link: ' . $my_array->external_urls->spotify,
          'music_genre' => 'Music Genre: ' . $my_array->genres[0],
        ]
      ];
      $form['images'] = [
        '#theme' => 'image',
        '#attributes' => [
          'width' => 300,
          'height' => 300,
          'style' => 'width: 300px; height: 300px;',
          'data-lazy' => TRUE,
          'src' => $my_array->images[1]->url,
        ]
      ];
    }

    if ($my_array->type == "track") {
      $form['options'] = [
        '#type' => 'checkboxes',
        '#my_array' => $my_array,
        '#options' => [
          'track_name' => 'Track Name: ' . $my_array->name,
          'artist_name' => 'Artist Name: ' . $my_array->artists[0]->name,
          'album_name' => 'Album Name: ' . $my_array->album->name,
          'release_date' => 'Release Date: ' . $my_array->album->release_date,
          'track_length' => 'Track Length: ' . $my_array->duration_ms,
          'spotify_link' => 'Spotify Link: ' . $my_array->external_urls->spotify,
        ]
      ];
      $form['images'] = [
        '#theme' => 'image',
        '#attributes' => [
          'width' => 300,
          'height' => 300,
          'style' => 'width: 300px; height: 300px;',
          'data-lazy' => TRUE,
          'src' => $my_array->album->images[1]->url,
        ]
      ];
    }
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => ('Submit'),
    ];

    return $form;
  }

  /**
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Component\Plugin\Exception\U
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.
    \Drupal::state()->set('options_checked', $form_state->getValue('options'));
    $options_checked = \Drupal::state()->get('options_checked');
    \Drupal::state()->set('my_array', $form_state->getCompleteForm('options'));
    $my_array = \Drupal::state()->get('my_array');
    $my_array = $my_array['options']['#my_array'];

    $values_to_save = [];
    if ($my_array->type == "artist") {
      foreach ($options_checked as $item) {
        if (!is_null($item) and $item == 'artist_name') {
          $values_to_save['artist_name'] = $my_array->name;
        }
        if (!is_null($item) and $item == 'spotify_link') {
          $values_to_save['spotify_link'] = $my_array->external_urls->spotify;
        }
        if (!is_null($item) and $item == 'music_genre') {
          $values_to_save['music_genre'] = $my_array->genres[0];
        }
      }
    }

    if ($my_array->type == "album") {
      foreach ($options_checked as $item) {
        if (!is_null($item) and $item == 'album_name') {
          $values_to_save['album_name'] = $my_array->name;
        }
        if (!is_null($item) and $item == 'artist_name') {
          $values_to_save['artist_name'] = $my_array->artists[0]->name;
        }
        if (!is_null($item) and $item == 'release_date') {
          $values_to_save['release_date'] = $my_array->release_date;
        }
        if (!is_null($item) and $item == 'spotify_link') {
          $values_to_save['spotify_link'] = $my_array->external_urls->spotify;
        }
        if (!is_null($item) and $item == 'total_tracks') {
          $values_to_save['total_tracks'] = $my_array->total_tracks;
        }
      }
    }
    if ($my_array->type == "track") {
      foreach ($options_checked as $item) {
        if (!is_null($item) and $item == 'track_name') {
          $values_to_save['track_name'] = $my_array->name;
        }
        if (!is_null($item) and $item == 'artist_name') {
          $values_to_save['artist_name'] = $my_array->artists[0]->name;
        }
        if (!is_null($item) and $item == 'album_name') {
          $values_to_save['album_name'] = $my_array->album->name;
        }
        if (!is_null($item) and $item == 'release_date') {
          $values_to_save['release_date'] = $my_array->album->release_date;
        }
        if (!is_null($item) and $item == 'track_length') {
          $values_to_save['track_length'] = $my_array->duration_ms;
        }
        if (!is_null($item) and $item == 'spotify_link') {
          $values_to_save['spotify_link'] = $my_array->external_urls->spotify;
        }
      }
    }
    $content_type = "";
    $title = "";
    if ($my_array->type == "artist") {
      $content_type = "listamadur";
      $title = $my_array->name;
    } elseif ($my_array->type == "track") {
      $content_type = "lag";
      $title = $my_array->name;
    } elseif ($my_array->type == "album") {
      $content_type = "plata";
      $title = $my_array->name;
    }
    $values = [
      'type' => $content_type,
      'title' => $title
    ];

    /** @var \Drupal\node\NodeInterface $node */
    $node = \Drupal::entityTypeManager()->getStorage('node')->create($values);
    if ($my_array->type == "track") {
      $photos[] = $this->_save_file($my_array->album->images[0]->url, 'track_images', 'image', $my_array->name, $my_array->name . '.jpg');
      $node->set('field_artist_name', $values_to_save["artist_name"] ?? NULL);
      $node->set('field_id' ,$values_to_save["spotify_link"] ?? NULL);
      $node->set('field_lengd_lags', $values_to_save["track_length"] ?? NULL);
      $node->set('field_release_date', $values_to_save["release_date"] ?? NULL);
      $node->set('field_album_name', $values_to_save["album_name"] ?? NULL);
      $node->set('field_lag_mynd', $photos[0] ?? NULL);
      $node->save();
      $nid = $node->id();
    }
    if ($my_array->type == "album") {
      $photos[] = $this->_save_file($my_array->images[0]->url, 'album_images', 'image', $my_array->name, $my_array->name . '.jpg');
      $node->set('field_artist_name_album', $values_to_save["artist_name"] ?? NULL);
      $node->set('field_hlekkur' ,$values_to_save["spotify_link"] ?? NULL);
      $node->set('field_utgafuar', $values_to_save["release_date"] ?? NULL);
      $node->set('field_umslags_mynd', $photos[0] ?? NULL);
      $node->save();
      $nid = $node->id();
    }
    if($my_array->type == "artist") {
      $photos[] = $this->_save_file($my_array->images[0]->url, 'artist_images', 'image', $my_array->name, $my_array->name . '.jpg');
      $node->set('field_vefsida_listamanns', $values_to_save["spotify_link"] ?? NULL);
      $node->set('field_listamadur_mynd', $photos[0] ?? NULL);
      $node->save();
      $nid = $node->id();
    }


    $form_state->setRedirect('entity.node.canonical',['node' => $nid]);
  }
    /**
     * Saves a file, based on it's type
     *
     * @param $url
     *   Full path to the image on the internet
     * @param $folder
     *   The folder where the image is stored on your hard drive
     * @param $type
     *   Type should be 'image' at all time for images.
     * @param $title
     *   The title of the image (like ALBUM_NAME - Cover), as it will appear in the Media management system
     * @param $basename
     *   The name of the file, as it will be saved on your hard drive
     *
     * @return int|null|string
     * @throws EntityStorageException
     */
    function _save_file($url, $folder, $type, $title, $basename, $uid = 1) {
      if (!is_dir(\Drupal::config('system.file')
          ->get('default_scheme') . '://' . $folder)) {
        return NULL;
      }
      $destination = \Drupal::config('system.file')
          ->get('default_scheme') . '://' . $folder . '/' . basename($basename);
      if (!file_exists($destination)) {
        $file = file_get_contents($url);
        $file = file_save_data($file, $destination);
      }
      else {
        $file = \Drupal\file\Entity\File::create([
          'uri' => $destination,
          'uid' => $uid,
          'status' => FILE_STATUS_PERMANENT
        ]);

        $file->save();
      }

      $file->status = 1;

      $media_type_field_name = 'field_media_image';

      $media_array = [
        $media_type_field_name => $file->id(),
        'name' => $title,
        'bundle' => $type,
      ];
      if ($type == 'image') {
        $media_array['alt'] = $title;
      }

      $media_object = \Drupal\media\Entity\Media::create($media_array);
      $media_object->save();
      return $media_object->id();
    }
}


