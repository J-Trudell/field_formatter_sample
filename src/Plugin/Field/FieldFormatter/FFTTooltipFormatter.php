<?php

namespace Drupal\field_formatter_sample\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'FFTTooltip' formatter.
 *
 * @FieldFormatter(
 *   id = "FFTTooltip",
 *   label = @Translation("FFT Tooltip"),
 *   description = @Translation("Display text with Tooltip."),
 *   field_types = {
 *     "text",
 *     "text_long",
 *     "text_with_summary"
 *   }
 * )
 */
class FFTTooltipFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'tooltip_message' => t('It works!'),
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'fft_tooltip',
        '#text' => $item->value,
        '#tooltip' => t('It works!'),
        '#attached' => [
          'library' => [
            'field_formatter_sample/fft-tooltip',
          ],
        ],
      ];
    }

    return $elements;
  }
}
