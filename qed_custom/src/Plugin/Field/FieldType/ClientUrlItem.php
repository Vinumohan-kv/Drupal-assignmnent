<?php

namespace Drupal\qed_custom\Plugin\Field\FieldType;

use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;

/**
 * Field type "qed_custom_client_url".
 *
 * @FieldType(
 *   id = "qed_custom_client_url",
 *   label = @Translation("Client Url"),
 *   description = @Translation("Custom Client Url field."),
 *   category = @Translation("Url"),
 *   default_widget = "client_url_default",
 *   default_formatter = "client_url_default",
 * )
 */
class ClientUrlItem extends FieldItemBase implements FieldItemInterface {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {

    module_load_include('inc', 'qed_custom');

    $output = array();

    // Create basic data.
    $client_urls = qed_custom_get_client_urls();
    foreach ($client_urls as $client_urls_key => $client_urls_name) {
      $output['columns'][$client_urls_key] = array(
        'type' => 'int',
        'length' => 1,
      );
    }

    return $output;

  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

    module_load_include('inc', 'qed_custom');

    $client_urls = qed_custom_get_client_urls();
    foreach ($client_urls as $client_urls_key => $client_urls_name) {
      $properties[$client_urls_key] = DataDefinition::create('boolean')
        ->setLabel($client_urls_name);
    }

    return $properties;

  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {

    $item = $this->getValue();

    $has_stuff = FALSE;

    // See if any of the client_urls checkboxes have been checked off.
    foreach (qed_custom_get_client_urls() as $client_urls_key => $client_urls_name) {
      if (isset($item[$client_urls_key]) && $item[$client_urls_key] == 1) {
        $has_stuff = TRUE;
        break;
      }
    }

    return !$has_stuff;

  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    return parent::defaultFieldSettings();
  }

  /**
   * Returns an array.
   *
   * @return array
   *   An associative array.
   */
  public function getClientUrls() {

    module_load_include('inc', 'qed_custom');

    $output = array();

    foreach (qed_custom_get_client_urls() as $client_urls_key => $client_urls) {
      if ($this->$client_urls_key) {
        $output[$client_urls_key] = $client_urls;
      }
    }

    return $output;

  }

}
