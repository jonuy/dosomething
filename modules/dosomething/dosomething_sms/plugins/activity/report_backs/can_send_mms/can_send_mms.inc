<?php

if (module_exists('entity')) {
  $plugin = array(
    'title' => t('Can Send MMS'),
    'description' => t('Handles response to whether or not user can send MMS.'),
    'handler' => array(
      'class' => 'ConductorActivityCanSendMMSReportBack',
    ),
  );
}
