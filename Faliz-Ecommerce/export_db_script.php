<?php
require_once 'includes/db.php';

$tables = [];
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}

$sql_dump = "-- Database Export for faliz_db\n";
$sql_dump .= "-- Date: " . date('Y-m-d H:i:s') . "\n\n";

foreach ($tables as $table) {
    $res = $conn->query("SHOW CREATE TABLE $table");
    $row = $res->fetch_assoc();
    
    $sql_dump .= "-- Table structure for table `$table`\n";
    $sql_dump .= "DROP TABLE IF EXISTS `$table`;\n";
    $sql_dump .= $row['Create Table'] . ";\n\n";
    
    // Optional: Dump Data (Sample data if needed, but schema is usually what's asked)
    // For this request "write all the tablys", schema is the priority. 
    // I'll add current data as INSERT statements to be helpful.
    
    $data_res = $conn->query("SELECT * FROM $table");
    if ($data_res->num_rows > 0) {
        $sql_dump .= "-- Dumping data for table `$table`\n";
        $sql_dump .= "INSERT INTO `$table` VALUES\n";
        $rows = [];
        while ($r = $data_res->fetch_row()) {
            $values = [];
            foreach ($r as $val) {
                if (is_null($val)) $values[] = "NULL";
                else $values[] = "'" . $conn->real_escape_string($val) . "'";
            }
            $rows[] = "(" . implode(", ", $values) . ")";
        }
        $sql_dump .= implode(",\n", $rows) . ";\n\n";
    }
}

file_put_contents('database.sql', $sql_dump);
echo "Database exported successfully to database.sql";
?>
