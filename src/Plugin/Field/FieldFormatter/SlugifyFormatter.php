<?php

namespace Drupal\field_formatter_sample\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\field_formatter_sample\SlugifyTextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'Slugify' formatter.
 *
 * @FieldFormatter(
 *   id = "Slugify",
 *   label = @Translation("Slugify"),
 *   description = @Translation("Display text as slug."),
 *   field_types = {
 *     "text",
 *     "text_long",
 *     "text_with_summary"
 *   }
 * )
 */
class SlugifyFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * Slugify service.
   *
   * @var \Drupal\field_formatter_sample\SlugifyTextInterface
   */
  protected $slugifyText;


  /**
   * SlugifyFormatter constructor.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   Defines an interface for the entity field definitions.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings.
   * @param \Drupal\field_formatter_sample\SlugifyTextInterface $slugifyText
   *   Service for converting text to slug.
   */

  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, SlugifyTextInterface $slugifyText) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);

    $this->slugifyText = $slugifyText;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('field_formatter_sample.slugifytext')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'separator' => '-',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary()
  {
    $summary = [];
    $separator = $this->getSetting('separator');
    $summary[] = t('Separator:') . ' ' . $separator;

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_State) {
    $elements = parent::settingsForm($form, $form_State);

    $elements['separator'] = [
      '#type' => 'textfield',
      '#title' => t('Choose a separator for the slug'),
      '#size' => 3,
      '#default_value' => $this->getSetting('separator'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $separator = $this->getSetting('separator');

    foreach ($items as $delta => $item) {
      $slug = $this->slugifyText->textToSlug($item->value, $separator);
      $elements[$delta] = [
        '#type' => 'processed_text',
        '#text' => $slug,
        '#format' => $item->format,
        '#langcode' => $item->getLangcode(),
      ];
    }

    return $elements;
  }
}
