<?php

namespace Drupal\qed_custom\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\WidgetInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Field widget "client_url_default".
 *
 * @FieldWidget(
 *   id = "client_url_default",
 *   label = @Translation("Client url default"),
 *   field_types = {
 *     "qed_custom_client_url",
 *   }
 * )
 */
class ClientUrlDefaultWidget extends WidgetBase implements WidgetInterface {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    // Load data.
    module_load_include('inc', 'qed_custom');

    $item =& $items[$delta];
    $element += array(
      '#type' => 'fieldset',
    );

    // Fieldset.
    $element['client_urls'] = array(
      '#title' => t('client_urls'),
      '#type' => 'fieldset',
      '#process' => array(__CLASS__ . '::processClientUrlsFieldset'),
    );

    // Create a checkbox item menu.
    foreach (qed_custom_get_client_urls() as $client_urls_key => $client_urls) {
      $element['client_urls'][$client_urls_key] = array(
        '#title' => t($client_urls),
        '#type' => 'checkbox',
        '#default_value' => isset($item->$client_urls_key) ? $item->$client_urls_key : '',
      );
    }

    return $element;

  }

  /**
   * Form widget process callback.
   */
  public static function processClientUrlsFieldset($element, FormStateInterface $form_state, array $form) {

    // Structuring of values.
    $elem_key = array_pop($element['#parents']);

    return $element;

  }

}
