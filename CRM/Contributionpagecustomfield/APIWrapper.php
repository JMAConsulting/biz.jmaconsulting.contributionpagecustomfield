<?php

class CRM_Contributionpagecustomfield_APIWrapper implements API_Wrapper {
  /**
   * the wrapper contains a method that allows you to alter the parameters of the api request (including the action and the entity)
   */
  public function fromApiInput($apiRequest) {
    return $apiRequest;
  }

  /**
   * Alter the result before returning it to the caller.
   */
  public function toApiOutput($apiRequest, $result) {
    if (!empty($apiRequest['params'])) {
      $id = $result['id'];
      contributionpagecustomfield_storeCustomField($apiRequest['params'], $id);
    }
    return $result;
  }

}
