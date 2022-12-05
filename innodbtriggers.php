<?php

require_once 'innodbtriggers.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function innodbtriggers_civicrm_config(&$config) {
  _innodbtriggers_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function innodbtriggers_civicrm_install() {
  _innodbtriggers_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function innodbtriggers_civicrm_uninstall() {
  _innodbtriggers_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function innodbtriggers_civicrm_enable() {
  _innodbtriggers_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function innodbtriggers_civicrm_disable() {
  _innodbtriggers_civix_civicrm_disable();
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
function innodbtriggers_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _innodbtriggers_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_alterLogTables().
 *
 * @param array $logTableSpec
 */
function innodbtriggers_civicrm_alterLogTables(&$logTableSpec) {
  $contactReferences = CRM_Dedupe_Merger::cidRefs();
  foreach (array_keys($logTableSpec) as $tableName) {
    $contactIndexes = array();
    $logTableSpec[$tableName]['engine'] = 'INNODB';
    $logTableSpec[$tableName]['engine_config'] = 'ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=4';
    $contactRefsForTable = CRM_Utils_Array::value($tableName, $contactReferences, array());
    foreach ($contactRefsForTable as $fieldName) {
      $contactIndexes['index_' . $fieldName] = $fieldName;
    }
    $indexArray = array(
      'index_log_conn_id' => 'log_conn_id',
      'index_log_date' => 'log_date',
    );
    // Check if current table has an "id" column. If so, index it too
    $dsn = DB::parseDSN(CIVICRM_DSN);
    $dbName = $dsn['database'];
    $dao = CRM_Core_DAO::executeQuery("
      SELECT COLUMN_NAME
      FROM   INFORMATION_SCHEMA.COLUMNS
      WHERE  TABLE_SCHEMA = '{$dbName}'
      AND    TABLE_NAME = '{$tableName}'
      AND    COLUMN_NAME = 'id'
      ");
    if ($dao->fetch()){
      $indexArray['index_id'] = 'id';
    }
    $logTableSpec[$tableName]['indexes'] = array_merge($indexArray, $contactIndexes);
  }
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function innodbtriggers_civicrm_postInstall() {
  _innodbtriggers_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function innodbtriggers_civicrm_entityTypes(&$entityTypes) {
  _innodbtriggers_civix_civicrm_entityTypes($entityTypes);
}
