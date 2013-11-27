<?php

if (module_exists('entity')) {
  $plugin = array(
    'title' => t('Sign Up Address Submit'),
    'description' => t('Submits the shipping address info for campaign sign ups.'),
    'handler' => array(
      'class' => 'ConductorActivitySignupAddressSubmit',
    ),
  );
}
