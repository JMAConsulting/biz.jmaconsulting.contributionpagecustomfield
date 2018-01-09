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
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function contributionpagecustomfield_civicrm_xmlMenu(&$files) {
  _contributionpagecustomfield_civix_civicrm_xmlMenu($files);
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
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function contributionpagecustomfield_civicrm_postInstall() {
  _contributionpagecustomfield_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function contributionpagecustomfield_civicrm_uninstall() {
  _contributionpagecustomfield_civix_civicrm_uninstall();
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
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function contributionpagecustomfield_civicrm_disable() {
  _contributionpagecustomfield_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function contributionpagecustomfield_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _contributionpagecustomfield_civix_civicrm_upgrade($op, $queue);
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
  _contributionpagecustomfield_civix_civicrm_managed($entities);
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
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function contributionpagecustomfield_civicrm_caseTypes(&$caseTypes) {
  _contributionpagecustomfield_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function contributionpagecustomfield_civicrm_angularModules(&$angularModules) {
  _contributionpagecustomfield_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function contributionpagecustomfield_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _contributionpagecustomfield_civix_civicrm_alterSettingsFolders($metaDataFolders);
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
    if (!empty($_POST['hidden_custom'])) {
      $form->set('type', 'ContributionPage');
      CRM_Custom_Form_CustomData::preProcess($form, NULL, NULL, 1, 'ContributionPage', $id);
      CRM_Custom_Form_CustomData::buildQuickForm($form);
      CRM_Custom_Form_CustomData::setDefaultValues($form);
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
 * Implements hook_civicrm_apiWrappers().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_apiWrappers
 *
 */
function contributionpagecustomfield_civicrm_apiWrappers(&$wrappers, $apiRequest) {
  if ($apiRequest['entity'] == 'ContributionPage' && $apiRequest['action'] == 'create') {
    $wrappers[] = new CRM_Contributionpagecustomfield_APIWrapper();
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
