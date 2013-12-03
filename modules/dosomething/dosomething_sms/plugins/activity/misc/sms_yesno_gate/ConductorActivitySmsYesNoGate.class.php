<?php

/**
 * Chooses next activity in the workflow based on whether input evaluates to a
 * YES or NO.
 */
class ConductorActivitySmsYesNoGate extends ConductorActivity {

  /**
   * Activity name to go if input is YES.
   *
   * @var string
   */
  public $onYesActivity;

  /**
   * Activity name to go if input is NO.
   *
   * @var string
   */
  public $onNoActivity;

  private $yesAnswers = array('y', 'ya', 'yea', 'yes');

  public function run() {
    $state = $this->getState();

    $userResponse = trim(check_plain($_REQUEST['args']));
    $userWords = explode(' ', $userResponse);
    $userFirstWord = strtolower(array_shift($userWords));

    if (in_array($userFirstWord, $this->yesAnswers)) {
      // Remove onNoActivity output, so it goes to the Yes activity
      $this->removeOutput($this->onNoActivity);
    }
    else {
      // Remove onYesActivity output, so it goes to the No activity
      $this->removeOutput($this->onYesActivity);
    }

    $state->markCompleted();
  }
}
