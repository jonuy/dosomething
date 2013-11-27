<?php

/**
 * Retrieve the value from the $_REQUEST args param and save it to a context
 * value to be used later in the Conductor workflow.
 */
class ConductorActivityArgsToContextValue extends ConductorActivity {

  /**
   * Context field to save 'args' parameter to.
   *
   * @var string
   */
  public $context_field;

  public function run($workflow) {
    $state = $this->getState();
    $mobile = $state->getContext('sms_number');

    $value = check_plain($_REQUEST['args']);
    $state->setContext($this->context_field, $value);

    $state->markCompleted();
  }

}
