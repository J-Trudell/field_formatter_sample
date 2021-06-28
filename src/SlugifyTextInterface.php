<?php

namespace Drupal\field_formatter_sample;

/**
 * Interface for Slugify Formatter.
 */
interface SlugifyTextInterface {

  /**
   * Convert text into slug using specified separator.
   *
   * @return string
   *   The Slug Text.
   */
  public function textToSlug($string, $separator);

}
