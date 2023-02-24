<?php

namespace Drupal\qed_custom\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Field formatter "client_url_default".
 *
 * @FieldFormatter(
 *   id = "client_url_default",
 *   label = @Translation("client_url default"),
 *   field_types = {
 *     "qed_custom_client_url",
 *   }
 * )
 */
class ClientUrlDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'client_urls' => 'list',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $output['client_urls'] = array(
      '#title' => t('client_urls'),
      '#type' => 'select',
      '#options' => array(
        'list' => t('Unordered list'),
      ),
      '#default_value' => $this->getSetting('client_urls'),
    );

    return $output;

  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {

    $summary = array();

    // Summary.
    $client_urls = FALSE;
    switch ($this->getSetting('client_urls')) {
      case 'list':
        $client_urls = 'Unordered list';
        break;

    }

    if ($client_urls) {
      $summary[] = t('client_urls display: @format', array(
        '@format' => t($client_urls),
      ));
    }

    return $summary;

  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $output = array();

    //@Todo - Logic need to build for all Select filter
    // Iterate over every field item
    foreach ($items as $delta => $item) {

      $build = array();

      // Render
      $client_urls_format = $this->getSetting('client_urls');
      $build['client_urls'] = array(
        '#type' => 'container',
        '#attributes' => array(
          'class' => array('client_urls'),
        ),
        'label' => array(
          '#type' => 'container',
          '#attributes' => array(
            'class' => array('field__label'),
          ),
          '#markup' => t('client_urls'),
        ),
        'value' => array(
          '#type' => 'container',
          '#attributes' => array(
            'class' => array('field__item'),
          ),

          'text' => $this->buildClientUrls($client_urls_format, $item),
        ),
      );

      $output[$delta] = $build;

    }

    return $output;

  }

  /**
   * Builds a renderable array.
   *
   * @param string $format
   *   The format in which to be displayed.
   *
   * @return array
   *   A renderable array of urls.
   */
  public function buildClientUrls($format, FieldItemInterface $item) {

    return array(
      '#theme' => 'item_list',
      '#items' => $item->getClientUrls(),
    );
  }

}
