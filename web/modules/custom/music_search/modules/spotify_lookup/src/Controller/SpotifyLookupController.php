<?php
namespace Drupal\spotify_lookup\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\spotify_lookup\SpotifyLookup;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SpotifyLookupController extends ControllerBase {

  /**
   * @var \Drupal\spotify_lookup\SpotifyLookup
   */
  protected $spotifylookup;

  public function __construct(SpotifyLookup $spotifylookup) {
    $this->spotifylookup = $spotifylookup;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('spotify_lookup.salutation')
    );
  }

  public function spotifyLookup() {
    return [
      '#markup' => $this->spotifylookup->getSpotifyLookup()
    ];
  }
}
