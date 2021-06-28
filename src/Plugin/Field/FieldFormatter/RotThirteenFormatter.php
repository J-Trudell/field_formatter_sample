<?php

namespace Drupal\field_formatter_sample\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'Rot13' formatter.
 *
 * @FieldFormatter(
 *   id = "Rot13",
 *   label = @Translation("Rot13 encoding"),
 *   description = @Translation("Display text in rot13 encoding."),
 *   field_types = {
 *     "text",
 *     "text_long",
 *     "text_with_summary"
 *   }
 * )
 */
class RotThirteenFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#type' => 'markup',
        '#markup' => fft_rot13($item->value),
      ];
    }

    return $elements;
  }
}
