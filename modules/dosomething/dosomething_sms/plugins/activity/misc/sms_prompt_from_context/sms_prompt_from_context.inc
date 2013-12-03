<?php

if (module_exists('entity')) {
  $plugin = array(
    'title' => t('SMS Prompt From Context'),
    'description' => t('SMS Prompt with the added ability to get the question from the Conductor State context.'),
    'handler' => array(
      'class' => 'ConductorActivitySMSPromptFromContext',
    ),
  );
}
