<?php
namespace Drupal\spotify_lookup;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

class SpotifyLookup {
  use StringTranslationTrait;

  protected $configFactory;

  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory;
  }
  public function getSpotifyLookup() {
    $config = $this->configFactory->get('spotify_lookup.api_keys');
    $spotifylookup = $config->get('spotifylookup');
    if ($spotifylookup !== "" && $spotifylookup) {
      return $spotifylookup;
  }
}
}
