<?php

if (module_exists('entity')) {
  $plugin = array(
    'title' => t('MMS Prompt'),
    'description' => t('Prompt for and expect to receive an MMS in return'),
    'handler' => array('class' => 'ConductorActivityMMSPrompt'),
  );
}
