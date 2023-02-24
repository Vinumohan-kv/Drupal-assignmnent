<?php

/**
 * @file
 * Contains utility functions.
 */

/**
 * Returns an array.
 * @return array
 *   An array of urls 
 */
function qed_custom_get_client_urls() {

  //@ToDo Logic for file read.
  $client_urls = array(
    'google.com', 'www.google.com', 'google.co.in', 'test.google.co.in', 'bling.com', 'qed42.net', 'test.qed42.net',
    'two.qed42.net',
  );
  return _qed_custom_client_urls_assoc($client_urls);

}

/**
 * Converts an array into an assocative array.
 */
function _qed_custom_client_urls_assoc($array) {
  $output = array();
  foreach ($array as $val) {
    $key = _qed_custom_make_machine_name($val);
    $output[$key] = $val;
  }
  return $output;
}

/**
 * Generates a machine name from a given string.
 */
function _qed_custom_make_machine_name($string) {
  $data = str_replace('.', '_', strtolower($string));
  return str_replace(' ', '_', $data);
}
