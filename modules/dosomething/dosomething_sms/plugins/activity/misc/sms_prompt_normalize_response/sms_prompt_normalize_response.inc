<?php

if (module_exists('entity')) {
  $plugin = array(
    'title' => t('SMS Prompt Normalize Response'),
    'description' => t('Same functionality as sms_prompt, but gives the option to normalize responses.'),
    'handler' => array(
      'class' => 'ConductorActivitySMSPromptNormalize',
    ),
  );
}
