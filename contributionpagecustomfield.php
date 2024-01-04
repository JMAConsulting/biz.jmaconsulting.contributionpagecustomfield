<?php

require_once 'contributionpagecustomfield.civix.php';
use CRM_Contributionpagecustomfield_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function contributionpagecustomfield_civicrm_config(&$config) {
  _contributionpagecustomfield_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function contributionpagecustomfield_civicrm_install() {
  _contributionpagecustomfield_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function contributionpagecustomfield_civicrm_enable() {
  _contributionpagecustomfield_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function contributionpagecustomfield_civicrm_managed(&$entities) {
  $entities[] = [
    'module' => 'biz.jmaconsulting.contributionpagecustomfield',
    'name' => 'contributionpagecustomfield',
    'update' => 'never',
    'entity' => 'OptionValue',
    'params' => [
      'label' => ts('Contribution Page'),
      'name' => 'civicrm_contribution_page',
      'value' => 'ContributionPage',
      'option_group_id' => 'cg_extend_objects',
      'is_active' => 1,
      'version' => 3,
    ],
  ];
}

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
 */
function contributionpagecustomfield_civicrm_preProcess($formName, &$form) {
  if ($formName == 'CRM_Contribute_Form_ContributionPage_Settings') {
    $form->assign('customDataType', 'ContributionPage');
    $id = $form->getVar('_id');
    if ($id) {
      $form->assign('entityID', $id);
    }
  }
}

/**
 * Implements hook_civicrm_postProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postProcess
 *
 */
function contributionpagecustomfield_civicrm_postProcess($formName, &$form) {
  if ($formName == 'CRM_Contribute_Form_ContributionPage_Settings') {
    $id = $form->get('id');
    $params = $form->_submitValues;
    contributionpagecustomfield_storeCustomField($params, $id);
  }
}

/**
 * Function to process custom fields for contribution page.
 *
 */
function contributionpagecustomfield_storeCustomField($params, $id) {
  $customValues = CRM_Core_BAO_CustomField::postProcess($params, $id, 'ContributionPage');
  if (!empty($customValues) && is_array($customValues)) {
    CRM_Core_BAO_CustomValueTable::store($customValues, 'civicrm_contribution_page', $id);
  }
}
