<?php

/**
 * Activity will check either the user's profile or search through webform submissions to find
 * the school associated for this user. Will update profile with school if it's found in the
 * webform submissions.
 *
 * @context school_sid
 *    Set with the school's ID value if one is found
 */
class ConductorActivitySmsCheckSchool extends ConductorActivity {

  /**
   * NID of the webform to check for user's school there. Used as backup if school's not found in profile.
   *
   * @var int
   */
  public $webform_nid_check = 0;

  /**
   * Name of the next activity to go to if a school was found.
   *
   * @var string
   */
  public $school_found_activity = 'school_found';

  /**
   * Name of the next activity to go to if no school was found.
   *
   * @var string
   */
  public $no_school_found_activity = 'no_school_found';

  public function run() {
    $state = $this->getState();
    $mobile = $state->getContext('sms_number');

    $bSchoolFound = FALSE;

    // @todo Needs new-world equivalent
    // $account = dosomething_api_user_lookup($mobile);
    // @todo Needs new-world equivalent
    // $profile = profile2_load_by_user($account, 'main');
    // @todo Needs new-world equivalent of getting user's school
    /*
    if (isset($profile->field_school_reference[LANGUAGE_NONE][0]['target_id'])) {
      // Use school set in profile if it exists.
      $school_sid = $profile->field_school_reference[LANGUAGE_NONE][0]['target_id'];
      $state->setContext('school_sid', $school_sid);
      $bSchoolFound = TRUE;
    }
    */
    // @todo Needs new-world equivalent of getting user's webform submissions to find school id
    /*
    elseif ($account->uid > 0 && $this->webform_nid_check > 0) {
      // Otherwise, search webform submissions for user's school
      module_load_include('inc', 'webform', 'includes/webform.submissions');
      $submissions = webform_get_submissions(array('uid' => $account->uid, 'nid' => $this->webform_nid_check));

      if (count($submissions) > 0) {
        $sub = array_shift($submissions);
        $school_sid = $sub->field_webform_school_reference[LANGUAGE_NONE][0]['target_id'];
        if (intval($school_sid) > 0) {
          // Update user's profile with the school found in this submission
          if ($profile) {
            $profile->field_school_reference[LANGUAGE_NONE][0]['target_id'] = $school_sid;
            profile2_save($profile);
          }

          $state->setContext('school_sid', $school_sid);
          $bSchoolFound = TRUE;
        }
      }
    }
    */

    self::selectNextOutput($bSchoolFound);
    $state->markCompleted();
  }

  private function selectNextOutput($bSchoolFound) {
    if ($bSchoolFound) {
      $this->removeOutput($this->no_school_found_activity);
    }
    else {
      $this->removeOutput($this->school_found_activity);
    }
  }

}

