<?php
require_once 'agegroup.civix.php';


/**
 * Implements hook_civicrm_post().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_post
 */

function agegroup_civicrm_post( $op, $objectName, $objectId, &$objectRef ) {
  if (($op = 'create' || $op == 'edit') && $objectName = 'Individual') {
    if (isset($objectRef->birth_date)) {
      //  call to get age
      $bday = $objectRef->birth_date;
      // Make sure bday isn't null.
      if($bday !== 'null') {
        $contact_age = get_age($bday);
        $contact_group = assign_age_group($contact_age);
        // Set the "age group" custom field.
        $result = civicrm_api3('CustomValue', 'create', array(
          'sequential' => 1,
          'entity_id' => $objectId,
          'custom_265' => $contact_group,
        ));
      }
    }
  }
}


function get_age($birthDate) {

  // Explode the date to get month, day and year
  $birthYear = substr($birthDate, 0, 4);
  $birthMonth = substr($birthDate, 4, 2);
  $birthDay = substr($birthDate, 6, 2);

  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birthMonth, $birthDay, $birthYear))) > date("md") ? ((date("Y") - $birthYear) - 1) : (date("Y") - $birthYear));
  return $age;
}

function assign_age_group($age) {
  if ($age < 13) {
    // No age group here, for now.
  } elseif ($age <= 17) {
    $group = 'age_group_13_17';
  } elseif ($age <= 25) {
    $group = 'age_group_18_25';
  } elseif ($age <= 35) {
    $group = 'age_group_26_35';
  } elseif ($age <= 50) {
    $group = 'age_group_36_50';
  } elseif ($age > 50) {
    $group = 'age_group_50_over';
  }
  return $group;
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function agegroup_civicrm_config(&$config) {
    _agegroup_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function agegroup_civicrm_xmlMenu(&$files) {
    _agegroup_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function agegroup_civicrm_install() {
    _agegroup_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function agegroup_civicrm_uninstall() {
    _agegroup_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function agegroup_civicrm_enable() {
    _agegroup_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function agegroup_civicrm_disable() {
    _agegroup_civix_civicrm_disable();
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
function agegroup_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
    return _agegroup_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function agegroup_civicrm_managed(&$entities) {
    _agegroup_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function agegroup_civicrm_caseTypes(&$caseTypes) {
    _agegroup_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function agegroup_civicrm_angularModules(&$angularModules) {
    _agegroup_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function agegroup_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
    _agegroup_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *
 /**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
 function agegroup_civicrm_preProcess($formName, &$form) {
 }
 */
