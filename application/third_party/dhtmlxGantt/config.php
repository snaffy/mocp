<?php

include('codebase/connector/db_mysqli.php');
include('codebase/connector/gantt_connector.php');

$dbtype = "MySQLi";
$res = new mysqli("localhost", "root", "", "constructiontask");
?>