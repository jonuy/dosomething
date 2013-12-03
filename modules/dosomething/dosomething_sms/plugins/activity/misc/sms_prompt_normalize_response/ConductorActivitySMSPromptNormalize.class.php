<?php

/**
 * Extends ConductorActivitySMSPrompt. Prompts user for a response, then takes
 * that response and normalizes it against any known options.
 */
class ConductorActivitySMSPromptNormalize extends ConductorActivitySMSPrompt {

  /**
   * List of responses to listen for and the value to normalize them to.
   *
   * Definition:
   * @code
   * array(
   *   array(<normalized value>, <unnormalized response 1>, ..., <unnormalized repsonse n>),
   *   ...
   * );
   * @endcode
   */
  public $normalizedGroups = array();

  public function run() {
    parent::run();

    $state = $this->getState();
    $message = $state->getContext($this->name . ':message');
    if ($message !== FALSE) {
      foreach ($this->normalizedGroups as $group) {
        if (self::in_arrayi($message, $group)) {
          // First item in array will be the normalized response
          $normalizedResponse = $group[0];
          $state->setContext($this->name . ':message', $normalizedResponse);
          break;
        }
      }
    }
  }

  /**
   * A case-insensitive version of in_array()
   */
  private function in_arrayi($needle, $haystack) {
    return in_array(strtolower(trim($needle)), array_map('strtolower', $haystack));
  }

}
