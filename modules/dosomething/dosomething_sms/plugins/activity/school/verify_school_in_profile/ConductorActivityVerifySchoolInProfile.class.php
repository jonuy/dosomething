<?php

/**
 * Enum-style class specifying the type of response the user replies back with
 * after being prompted to verify the school.
 */
class UserResponseType {
  const YES = 0;
  const NO = 1;
  const INVALID = 2;
};

/**
 * After determining the user does have a school set in his profile, this activity
 * will prompt the user to verify the school that we do have for them and handle
 * his response accordingly.
 */
class ConductorActivityVerifySchoolInProfile extends ConductorActivity {

  /**
   * Message sent to user asking her to verify the school we have in her.
   * profile. Use @school_name to insert the school name into the message.
   *
   * @var string
   */
  public $question = '';

  /**
   * Message sent to user if they reply with an invalid response.
   *
   * @var string
   */
  public $invalid_response_msg = '';

  /**
   * Array of key-value pairs of mData IDs and the keywords associated with them.
   * Used by the return messages to let users know what keyword to use to try again.
   *
   * @var array
   */
  public $mdata_keywords;

  /**
   * Name of the output activity to go to if the school in the user profile is correct.
   *
   * @var string
   */
  public $output_school_correct = '';

  /**
   * Name of the output activity to go to if the school in the user profile is incorrect.
   *
   * @var string
   */
  public $output_school_incorrect = '';

  public function run() {
    $state = $this->getState();

    $userResponse = $state->getContext($this->name . ':message');
    // First run through this activity will prompt user to verify their school
    // name, or continue to the school search output if no GSID can be found.
    if ($userResponse === FALSE) {
      $mobile = $state->getContext('sms_number');
      $schoolSid = $state->getContext('school_sid');

      // Ensure there's a valid Great Schools ID for this school
      $school = db_query('SELECT * FROM ds_school WHERE `sid` = :sid', array(':sid' => $schoolSid))->fetchAll();
      if (!empty($school) && $school[0] && $school[0]->gsid > 0) {
        $state->setContext('school_gsid', $school[0]->gsid);
        $state->setContext('selected_school_state', $school[0]->state);
        $schoolName = $school[0]->name;

        // Verify with the user that we have the correct school
        $state->setContext('selected_school_name', $schoolName);
        $state->setContext('sms_response', t($this->question, array('@school_name' => $schoolName)));

        // Await response
        $state->markSuspended();
      }
      // If there is no Great Schools ID, then end this activity and go on to the school search
      else {
        self::selectNextOutput(UserResponseType::NO);
      }
    }
    else {
      $userResponse = trim(strtoupper($userResponse));
      $words = explode(' ', $userResponse);
      $firstWord = $words[0];

      // If response is yes, continue to questions
      if ($firstWord == 'Y' || $firstWord == 'YA' || $firstWord == 'YEA' || $firstWord == 'YES') {
        self::selectNextOutput(UserResponseType::YES);
      }
      // If response is no, continue to school searching
      elseif ($firstWord == 'N' || $firstWord == 'NO') {
        // Clear the selected_school_name context
        unset($state->context['selected_school_name']);

        self::selectNextOutput(UserResponseType::NO);
      }
      // If response is invalid, notify user and go to End
      else {
        // Get the restart keyword, if any, based on the mdata ID
        $restartKeyword = "";
        foreach($this->mdata_keywords as $mdataId => $mDataKeyword) {
          if (intval($_REQUEST['mdata_id']) == $mdataId) {
            $restartKeyword = $mDataKeyword;
          }
        }

        // Set the message for an invalid response
        $state->setContext('sms_response', t($this->invalid_response_msg, array('@keyword' => $restartKeyword)));
        self::selectNextOutput(UserResponseType::INVALID);
      }
    }
  }

  /**
   * Modify the outputs array to select the correct one to go to based on the
   * user's response to the verification prompt.
   *
   * @param int $responseType
   *   See UserResponseType class.
   */
  private function selectNextOutput($responseType) {
    if ($responseType == UserResponseType::YES) {
      // Go to the output activity for case where the school is correct
      $this->removeOutput($this->output_school_incorrect);
      $this->removeOutput('end');
    }
    elseif ($responseType == UserResponseType::NO) {
      // Go to the output activity for case where the school is incorrect
      $this->removeOutput($this->output_school_correct);
      $this->removeOutput('end');
    }
    else {
      // Go to the 'end' activity
      $this->removeOutput($this->output_school_correct);
      $this->removeOutput($this->output_school_incorrect);
    }

    $this->getState()->markCompleted();
  }

  /**
   * Implements ConductorActivity::getSuspendPointers().
   */
  public function getSuspendPointers(ConductorWorkflow $workflow = NULL) {
    return array(
      'sms_prompt:' . $this->getState()->getContext('sms_number')
    );
  }

}
