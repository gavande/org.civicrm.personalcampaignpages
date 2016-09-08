<?php

require_once 'CRM/Core/Page.php';

class CRM_Personalcampaignpages_Page_ContactPCP extends CRM_Core_Page {

  public function run() {

  	$result = civicrm_api3('PersonalCampaignPage', 'get', array(
	  'sequential' => 1,
	  'contact_id' => $_GET['contact_id'],
	));

  	$this->assign('rows', $result['values']);	

	return parent::run();
  }
}
