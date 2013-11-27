<?php

if (module_exists('entity')) {
  $plugin = array(
    'title' => t('Args to Context Value'),
    'description' => t('Save value from $_REQUEST args param and save it to a context value to be used later in the Conductor workflow'),
    'handler' => array(
      'class' => 'ConductorActivityArgsToContextValue',
    ),
  );
}
