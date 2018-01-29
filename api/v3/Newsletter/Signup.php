<?php
use CRM_Api_ExtensionUtil as E;

/**
 * Newsletter.Signup API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_newsletter_Signup_spec(&$spec) {
  $spec['email']['api.required'] = 1;
	$spec['organization'] = array(
    'title' => 'Organization',
    'description' => 'Name of Current Employer',
    'type' => CRM_Utils_Type::T_STRING,
  );
	$spec['first_name'] = array(
    'title' => 'First name',
    'type' => CRM_Utils_Type::T_STRING,
  );
	$spec['last_name'] = array(
    'title' => 'Last name',
    'type' => CRM_Utils_Type::T_STRING,
  );
	$spec['group'] = array(
    'title' => 'Group',
    'type' => CRM_Utils_Type::T_STRING,
    'api.required' => 1,
  );
}

/**
 * Newsletter.Signup API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_newsletter_Signup($params) {
	$apiParams['contact_type'] = 'Individual';
  $apiParams['email'] = $params['email'];
	if (isset($params['organization'])) {
		$apiParams['current_employer'] = $params['organization'];
	}
	if (isset($params['first_name'])) {
		$apiParams['first_name'] = $params['first_name'];
	} 
	if (isset($params['last_name'])) {
		$apiParams['last_name'] = $params['last_name'];
	}  
	
	try {
		$returnContactCreate = civicrm_api3('Contact', 'create', $apiParams);
		$contact_id = $returnContactCreate['id'];
	} catch (Exception $e) {
		return civicrm_api3_create_error('Error during signup');
	}

	try {
		civicrm_api3('GroupContact', 'create', array(
		  'sequential' => 1,
		  'group_id' => $params['group'],
		  'contact_id' => $contact_id,
		));
	} catch (Exception $e) {
		return civicrm_api3_create_error('Could create a contact but not able to add the contact to a group');
	}
	
	return civicrm_api3_create_success();
}
