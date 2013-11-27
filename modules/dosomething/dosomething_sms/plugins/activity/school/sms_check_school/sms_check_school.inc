<?php

if (module_exists('entity')) {
  $plugin = array(
    'title' => t('Check User\'s School'),
    'description' => t('Determine if we have a school set for a given user'),
    'handler' => array(
      'class' => 'ConductorActivitySmsCheckSchool',
    ),
  );
}
