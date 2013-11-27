<?php

/**
 * Question prompt for the user is pulled from the Conductor state context. Then
 * continues to prompt with question and save user response.
 */
class ConductorActivitySMSPromptFromContext extends ConductorActivitySMSPrompt {

  /**
   * Context key to find question user should be prompted with.
   *
   * @var string
   */
  public $question_context_key = '';

  public function run($workflow) {
    $state = $this->getState();
    if ($state->getContext($this->name . ':message') === FALSE && !empty($this->question_context_key)) {
      $question = $state->getContext($this->question_context_key);
      $state->setContext('sms_response', $question);
      $state->markSuspended();
    }
    else {
      parent::run();
    }
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
