<?php

class Gantt_connector extends CI_Model
{
    private  $dbtype;
    private $res;
    private $projectID;
    private $userID;
    /**
     * Gantt_connector constructor.
     */
    public function __construct()
    {
        include(APPPATH . 'third_party/dhtmlxGantt/codebase/connector/db_mysqli.php');
        include(APPPATH . 'third_party/dhtmlxGantt/codebase/connector/gantt_connector.php');

        $this->dbtype = "MySQLi";
        $this->res = new mysqli("localhost", "snaffyc_admin", "volexideus13", "snaffyc_mct");
        $this->res->set_charset('utf8');
        $this->projectID = $this->session->get_userdata()['projectID'];
        $this->userID = $this->session->get_userdata()['userID'];
    }
    function myUpdate($action){
        $action->set_value("project_id_project", $this->projectID);
        $action->set_value("user_id_user", $this->userID);
    }
    public function connector()
    {
        $gantt = new JSONGanttConnector( $this->res,  $this->dbtype);
        $gantt->mix("open", 1);
//        $user = new JSONDataConnector( $this->res,  $this->dbtype);
//        $user->configure("user","email","name","surname");
////$gantt->enable_order("sortorder");
//        $gantt->mix("user",1,array("id_user"=>"user_id_user"));

        $gantt->render_links("gantt_links", "id", "source,target,type");
        $gantt->event->attach('beforeInsert',array($this,'myUpdate'));
        $gantt->event->attach('beforeUpdate',array($this,'myUpdate'));
        if($gantt->is_select_mode())
        {
//            $grid->render_table("tableA","id","name,price(product_price)");
            $gantt->render_sql("SELECT * FROM gantt_tasks WHERE gantt_tasks.project_id_project=$this->projectID ","id","start_date,end_date,text,progress,parent,priority,id_project,user_id_user,budget","");
        }
        $gantt->render_table("gantt_tasks", "id", "start_date,end_date,text,progress,parent,priority,project_id_project,user_id_user,budget", "");






    }
}


?>