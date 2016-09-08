<?php

require_once 'personalcampaignpages.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function personalcampaignpages_civicrm_config(&$config) {
  _personalcampaignpages_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function personalcampaignpages_civicrm_xmlMenu(&$files) {
  _personalcampaignpages_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function personalcampaignpages_civicrm_install() {
  _personalcampaignpages_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function personalcampaignpages_civicrm_uninstall() {
  _personalcampaignpages_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function personalcampaignpages_civicrm_enable() {
  _personalcampaignpages_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function personalcampaignpages_civicrm_disable() {
  _personalcampaignpages_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function personalcampaignpages_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _personalcampaignpages_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function personalcampaignpages_civicrm_managed(&$entities) {
  _personalcampaignpages_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * @param array $caseTypes
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function personalcampaignpages_civicrm_caseTypes(&$caseTypes) {
  _personalcampaignpages_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * 
 */
/*
function personalcampaignpages_civicrm_angularModules(&$angularModules) {
   
}
*/
/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function personalcampaignpages_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _personalcampaignpages_civix_civicrm_alterSettingsFolders($metaDataFolders);
}


function personalcampaignpages_civicrm_tabset($tabsetName, &$tabs, $context) {

  //check if the tabset is Contact Summary Page
  if ($tabsetName == 'civicrm/contact/view') {
    
    $contactId = $context['contact_id'];

    $count = civicrm_api3('PersonalCampaignPage', 'getcount', array(
      'sequential' => 1,
      'contact_id' => $contactId,
    ));



    // let's add a new "Personal Comapaign Pages" tab with a different name and put it last
    // return an html snippet etc
    // 
    $url = CRM_Utils_System::url( 'civicrm/contactpcp',
                                  "reset=1&snippet=1&force=1&contact_id=$contactId" );
    
    $tabs[] = array( 'id' => 'myPersonalCampaigns',
      'url'   => $url,
      'title' => 'Personal Campaign Pages',
      'weight' => 800,
      'count' => $count
    );

  }
}
