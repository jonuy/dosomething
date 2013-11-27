<?php

/**
 * Submits a campaign sign up.
 */
class ConductorActivitySmsSignupSubmit extends ConductorActivity {

  /**
   * Node ID of the campaign being signed up for.
   *
   * @var int
   */
  public $nid;

  /**
   * Context value to get the GSID from.
   *
   * @var String
   */
  public $schoolContext;

  public function run() {
    $state = $this->getState();
    $mobile = $state->getContext('sms_number');

    // @todo Needs new-world equivalent
    // $user = sms_flow_get_or_create_user_by_cell($mobile);
    if ($user && isset($this->nid)) {

      // Get the school GSID if given a context to get the data from
      $schoolGsid = NULL;
      if (isset($this->schoolContext)) {
        $schoolGsid = intval($state->getContext($this->schoolContext));
      }

      // Submit the sign up as long as the user hasn't already signed up before
      // @todo Needs new-world equivalent
      /*
      if (!dosomething_signups_is_user_signed_up($user->uid, $this->nid)) {
        dosomething_signups_insert_signup($user->uid, $this->nid, $schoolGsid);
      }
      */
    }

    $state->markCompleted();
  }

}
