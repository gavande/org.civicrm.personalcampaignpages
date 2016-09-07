<?php

/**
 * Pcp.Get API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_pcp_get_spec(&$spec) {
  $spec['contact_id']['api.required'] = 1;
}

/**
 * Pcp.Get API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */

function civicrm_api3_pcp_get($params) {

  $pcpSummary = _get_pcp_contact($params['contact_id']);

  return civicrm_api3_create_success($pcpSummary, $params, 'NewEntity', 'NewAction');  

}

function _get_pcp_contact($contact_id){

    //Init our array
    $pcpSummary = array();

    // Get list of status messages
    $status = CRM_PCP_BAO_PCP::buildOptions('status_id', 'create');

    $query = "
        SELECT cp.*
        FROM civicrm_pcp cp
        WHERE cp.contact_id = '$contact_id' ORDER BY cp.status_id";

    $pcp = CRM_Core_DAO::executeQuery($query);

    while ($pcp->fetch()) {

      $contact = CRM_Contact_BAO_Contact::getDisplayAndImage($pcp->contact_id);

      $page_type = $pcp->page_type;
      
      $page_id = (int) $pcp->page_id;

      $page = _get_page($page_type, $page_id);

      if ($pcp->page_type == 'contribute') {
        $pageUrl = CRM_Utils_System::url('civicrm/' . $page_type . '/transact', 'reset=1&id=' . $pcp->page_id);
      }
      else {
        $pageUrl = CRM_Utils_System::url('civicrm/' . $page_type . '/register', 'reset=1&id=' . $pcp->page_id);
      }

      $edit_action =  CRM_Utils_System::url( 'civicrm/pcp/info',
                                  "action=update&reset=1&id={$pcp->id}&context=dashboard",
                                  false, null, false,true);

      $honorRoll = CRM_PCP_BAO_PCP::honorRoll($pcp->id);

      $contributions = count($honorRoll);

      $pcpSummary[$pcp->id] = array(

        'id' => $pcp->id,
        'page_id' => $page_id,
        'title' => $pcp->title,             
        'page_title' => $page['title'],        
        'goal_amount' => $pcp->goal_amount,
        'contributions' => $contributions,
        'achieved' => CRM_PCP_BAO_PCP::thermoMeter($pcp->id),
        'currency' => $pcp->currency,
        'page_type' => $page_type,
        'page_url' => $pageUrl,
        'edit_action' => $edit_action,
        'start_date' => $page['start_date'],
        'end_date' => $page['end_date'],
        'status' => $status[$pcp->status_id]

      );
    }

    return $pcpSummary;
}

function _get_page($page_type, $page_id){
      
      if($page_type === "contribute")
      {

        $query = "SELECT id, title, start_date, end_date FROM civicrm_contribution_page WHERE id = '$page_id'";
        $cpages = CRM_Core_DAO::executeQuery($query);
        while ($cpages->fetch()) {
          $pages['contribute'][$cpages->id]['id'] = $cpages->id;
          $pages['contribute'][$cpages->id]['title'] = $cpages->title;
          $pages['contribute'][$cpages->id]['start_date'] = $cpages->start_date;
          $pages['contribute'][$cpages->id]['end_date'] = $cpages->end_date;
        }

      }else{
        
        $query = "SELECT id, title, start_date, end_date, registration_start_date, registration_end_date
                    FROM civicrm_event
                    WHERE is_template IS NULL OR is_template != 1 AND id = '$page_id'";

        $epages = CRM_Core_DAO::executeQuery($query);
        while ($epages->fetch()) {
          $pages['event'][$epages->id]['id'] = $epages->id;
          $pages['event'][$epages->id]['title'] = $epages->title;
          $pages['event'][$epages->id]['start_date'] = $epages->registration_start_date;
          $pages['event'][$epages->id]['end_date'] = $epages->registration_end_date;
        }
      }

      if ($pages[$page_type][$page_id]['title'] == '' || $pages[$page_type][$page_id]['title'] == NULL) {
        $title = '(no title found for ' . $page_type . ' id ' . $page_id . ')';
      }
      else {
        $title = $pages[$page_type][$page_id]['title'];
      }

      return ['title' => $title, 'start_date' => $pages[$page_type][$page_id]['start_date'], 'end_date' => $pages[$page_type][$page_id]['end_date']];
}
