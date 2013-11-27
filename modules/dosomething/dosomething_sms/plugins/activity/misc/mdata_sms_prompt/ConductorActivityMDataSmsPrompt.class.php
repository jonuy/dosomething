<?php

/**
 * Uses the current mData ID to determine what question to ask.
 */
class ConductorActivityMDataSmsPrompt extends ConductorActivitySMSPrompt {

  /**
   * Array of key-value pairs of mdata IDs and the corresponding question to ask
   * for that ID.
   *
   * @var array
   */
  public $questions;

  public function run() {
    $state = $this->getState();

    if ($state->getContext($this->name . ':message') === FALSE && !empty($this->questions)) {
      // Determine question to ask based off of the requesting mData's ID
      $callingMdata = intval($_REQUEST['mdata_id']);
      foreach ($this->questions as $mdataId => $question) {
        if ($mdataId == $callingMdata) {
          $state->setContext('sms_response', $question);
          $state->markSuspended();
          return;
        }
      }
    }

    parent::run();
  }

  /**
   * Implements ConductorActivity::getSuspendPointers().
   */
  public function getSuspendPointers() {
    return array(
      'sms_prompt:' . $this->getState()->getContext('sms_number')
    );
  }
}
