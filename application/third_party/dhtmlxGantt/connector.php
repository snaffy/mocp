<?php

include('config.php');

$gantt = new JSONGanttConnector($res, $dbtype);

$gantt->mix("open", 1);
//$gantt->enable_order("sortorder");

$gantt->render_links("gantt_links", "id", "source,target,type");
//,progress,parent,priority
$gantt->render_table("gantt_tasks","id","start_date,duration,text,progress,parent,priority","");
//  $gantt->render_sql("SELECT * FROM gantt_tasks WHERE id=35","id","start_date,duration,text,progress,parent,priority","");

?>