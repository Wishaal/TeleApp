<?php
//mis database connection
$mis_servername = '';
$mis_conn_info = array('database' => '', 'ReturnDatesAsStrings' => true);
$mis_conn = sqlsrv_connect($mis_servername, $mis_conn_info) or die('Could not connect to the server!');
define('MIS_CONN', $mis_conn);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(-1);
/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "username";

/* DB table to use */
$sTable = "log_users";
/*
* Columns
* If you don't want all of the columns displayed you need to hardcode $aColumns array with your elements.
* If not this will grab all the columns associated with $sTable
*/
$aColumns = array('id', 'username', 'session', 'ip_address', 'refurl', 'activity', 'datum');


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
 * no need to edit below this line
 */

/*
 * ODBC connection
 */
$params = array();
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);


/* Ordering */
$sOrder = "";
if (isset($_GET['iSortCol_0'])) {
    $sOrder = "ORDER BY  ";
    for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
        if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
            $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
                    " . addslashes($_GET['sSortDir_' . $i]) . ", ";
        }
    }
    $sOrder = substr_replace($sOrder, "", -2);
    if ($sOrder == "ORDER BY") {
        $sOrder = "";
    }
}

/* Filtering */
$sWhere = "";
if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
    $sWhere = "WHERE (";
    for ($i = 0; $i < count($aColumns); $i++) {
        $sWhere .= $aColumns[$i] . " LIKE '%" . addslashes($_GET['sSearch']) . "%' OR ";
    }
    $sWhere = substr_replace($sWhere, "", -3);
    $sWhere .= ')';
}
/* Individual column filtering */
for ($i = 0; $i < count($aColumns); $i++) {
    if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
        if ($sWhere == "") {
            $sWhere = "WHERE ";
        } else {
            $sWhere .= " AND ";
        }
        $sWhere .= $aColumns[$i] . " LIKE '%" . addslashes($_GET['sSearch_' . $i]) . "%' ";
    }
}

/* Paging */
$top = (isset($_GET['iDisplayStart'])) ? ((int)$_GET['iDisplayStart']) : 0;
$limit = (isset($_GET['iDisplayLength'])) ? ((int)$_GET['iDisplayLength']) : 10;
$sQuery = "SELECT TOP $limit " . implode(",", $aColumns) . "
        FROM $sTable
        $sWhere " . (($sWhere == "") ? " WHERE " : " AND ") . " $sIndexColumn NOT IN
        (
            SELECT $sIndexColumn FROM
            (
                SELECT TOP $top " . implode(",", $aColumns) . "
                FROM $sTable
                $sWhere
                $sOrder
            )
            as [virtTable]
        )
        $sOrder";

$rResult = sqlsrv_query(MIS_CONN, $sQuery) or die("$sQuery: " . sqlsrv_errors());

$sQueryCnt = "SELECT * FROM $sTable $sWhere";
$rResultCnt = sqlsrv_query(MIS_CONN, $sQueryCnt, $params, $options) or die (" $sQueryCnt: " . sqlsrv_errors());
$iFilteredTotal = sqlsrv_num_rows($rResultCnt);

$sQuery = " SELECT * FROM $sTable ";
$rResultTotal = sqlsrv_query(MIS_CONN, $sQuery, $params, $options) or die(sqlsrv_errors());
$iTotal = sqlsrv_num_rows($rResultTotal);

$output = array(
    "sEcho" => intval($_GET['sEcho']),
    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => array()
);

while ($aRow = sqlsrv_fetch_array($rResult)) {
    $row = array();
    for ($i = 0; $i < count($aColumns); $i++) {
        if ($aColumns[$i] != ' ') {
            $v = $aRow[$aColumns[$i]];
            $v = mb_check_encoding($v, 'UTF-8') ? $v : utf8_encode($v);
            $row[] = $v;
        }
    }
    If (!empty($row)) {
        $output['aaData'][] = $row;
    }
}
echo json_encode($output);
?>