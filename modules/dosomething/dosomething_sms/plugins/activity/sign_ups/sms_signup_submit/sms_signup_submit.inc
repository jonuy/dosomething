<?php

if (module_exists('entity')) {
  $plugin = array(
    'title' => t('Submit Campaign Sign Up'),
    'description' => t('Submits a campaign sign up.'),
    'handler' => array(
      'class' => 'ConductorActivitySmsSignupSubmit',
    ),
  );
}
