<?php

try {
// Open database connection
$conn = new \PDO("sqlsrv:Server=telsur63b; Database=woningenVerhuur;", "", "");
// Query database for events in range
$stmt = $conn->prepare("select * from json_calenderAdmin where ws_id in (2,3,4)");
$stmt->execute();
// Fetch query results
$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
// Return query results as JSON
echo json_encode($results);
} catch (\PDOException $e) {
$app->halt(500, $e->getMessage());
}
?>