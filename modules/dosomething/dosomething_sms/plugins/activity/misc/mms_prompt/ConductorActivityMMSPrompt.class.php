<?php

/**
 * Extends ConductorActivitySMSPrompt. Asks user a question and expects an MMS
 * image in return.
 */
class ConductorActivityMMSPrompt extends ConductorActivitySMSPrompt {

  /**
   * If FALSE, image is already incoming without the need for a prompt.
   *
   * @var bool
   */
  public $should_prompt = TRUE;

  /**
   * (optional) If set and no mms image is found, will send respond with specified
   * response and send user to the end activity in the workflow.
   *
   * @var mixed
   */
  public $no_mms_response;

  public function run() {
    $state = $this->getState();

    // If :has_prompted is not set, then this is first time through the activity
    // and should prompt the user with the question
    if ($state->getContext($this->name . ':has_prompted') === FALSE && $this->should_prompt) {
      $state->setContext($this->name . ':has_prompted', TRUE);
      parent::run();
    }
    // Process user's response, expecting any mms to be in $_REQUEST['mms_image_url']
    // If none is set, end the activity regardless
    else {
      $mms_image_url = $_REQUEST['mms_image_url'];
      if (!empty($mms_image_url)) {
        $state->setContext($this->name . ':mms', $mms_image_url);
      }
      elseif (!empty($this->no_mms_response)) {
        // Send the response for no MMS found - set either as a Mobile Commons opt-in path or string
        if (is_numeric($this->no_mms_response)) {
          $mobile = $state->getContext('sms_number');
          dosomething_sms_mobile_commons_opt_in($mobile, $this->no_mms_response);
          $state->setContext('ignore_no_response_error', TRUE);
        }
        else {
          $state->setContext('sms_response', $this->no_mms_response);
        }

        // Send user to the end of the workflow
        self::useOutput('end');
      }

      $state->markCompleted();
    }
  }

  /**
   * Removes all outputs from this activity except for the one specified in the param
   *
   * @param string $activityName
   *   Name of activity in outputs array to keep
   */
  private function useOutput($activityName) {
    foreach($this->outputs as $key => $val) {
      if ($val != $activityName) {
        unset($this->outputs[$key]);
      }
    }
  }

}
