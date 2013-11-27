<?php

if (module_exists('entity')) {
  $plugin = array(
    'title' => t('Verify School In Profile'),
    'description' => t('Prompts user with current school in their profile and asks them to verify.'),
    'handler' => array(
      'class' => 'ConductorActivityVerifySchoolInProfile',
    ),
  );
}
