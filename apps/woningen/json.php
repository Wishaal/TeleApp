<?php

try {
// Open database connection
$conn = new \PDO("sqlsrv:Server=telsur63b; Database=woningenVerhuur;", "", "");
if(strpos($_GET['type'], 'STAF') !== false) {
    $extra = '4,3';
}elseif(strpos($_GET['type'], 'DIR') !== false){
    $extra = '4,3';
}
else{
    $extra = '1,3';
}
// Query database for events in range
$stmt = $conn->prepare("select * from json_calender where ws_id in (".$extra.")");
$stmt->execute();
// Fetch query results
$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
// Return query results as JSON
echo json_encode($results);
} catch (\PDOException $e) {
$app->halt(500, $e->getMessage());
}
?>