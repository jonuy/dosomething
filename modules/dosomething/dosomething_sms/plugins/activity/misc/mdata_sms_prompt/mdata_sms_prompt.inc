<?php

if (module_exists('entity')) {
  $plugin = array(
    'title' => t('mData SMS Prompt'),
    'description' => t('Uses the current mData ID to determine what question to ask.'),
    'handler' => array(
      'class' => 'ConductorActivityMDataSmsPrompt',
    ),
  );
}
