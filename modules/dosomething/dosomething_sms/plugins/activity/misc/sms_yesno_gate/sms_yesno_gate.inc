<?php

if (module_exists('entity')) {
  $plugin = array(
    'title' => t('Do Something SMS Yes/No Gate'),
    'description' => t('Chooses next activity in the workflow based on whether input evaluates to a YES or NO.'),
    'handler' => array(
      'class' => 'ConductorActivitySmsYesNoGate',
    ),
  );
}
