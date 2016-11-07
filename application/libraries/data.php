<?php

require  APPPATH.'libraries/codebase/connector/db_sqlite3.php';
require  APPPATH.'libraries/codebase/connector/gantt_connector.php';

// Mysql
define('DB_USER','projects_test');
define('DB_PASS','user_pass');
define('DB_HOST','localhost');

 $dbtype = "MySQL";
$res=mysql_connect(DB_HOST,DB_USER,DB_PASS) or die ("Unable to connect!");
mysql_select_db("constructiontask");

$gantt = new JSONGanttConnector($res, $dbtype);

$gantt->mix("open", 1);
//$gantt->enable_order("sortorder");

$gantt->render_links("gantt_links", "id", "source,target,type");
$gantt->render_table("gantt_tasks","id",
    "start_date,duration,text,progress,sortorder,parent","");

?>