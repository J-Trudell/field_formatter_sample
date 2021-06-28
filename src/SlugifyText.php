<?php

namespace Drupal\field_formatter_sample;

use Cocur\Slugify\Slugify;

/**
 * Define the Slugify Class.
 *
 * @package Drupal\field_formatter_test
 */
class SlugifyText implements SlugifyTextInterface {

  /**
   * Slugify Object.
   */
  protected $slugify;

  /**
   * Create Slugify Instance.
   */
  public function __construct() {
    $this->slugify = new Slugify();
  }

  /**
   * {@inheritdoc}
   */
  public function textToSlug($string, $separator) {
    return $this->slugify->slugify($string, $separator);
  }
}
