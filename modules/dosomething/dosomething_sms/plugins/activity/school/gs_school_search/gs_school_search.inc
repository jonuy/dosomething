<?php

if (module_exists('entity')) {
  $plugin = array(
    'title' => t('Great Schools SMS Search'),
    'description' => t('Given state and school name, search for schools on the Great Schools database.'),
    'handler' => array(
      'class' => 'ConductorActivityGsSchoolSearch',
    ),
  );
}
