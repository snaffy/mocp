<?php

/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 02.11.2016
 * Time: 00:40
 */
class User_projects extends My_Controller
{
    protected $projectID;
    public function __construct()
    {
        parent:: __construct();
        $this->load->helper('url');
        if ($this->input->post('selectedProjectID') != null) {
            $this->session->set_userdata('projectID', $this->input->post('selectedProjectID'));
        }
        $this->projectID =  $this->session->get_userdata()['projectID'];
        if($this->projectID == null)
        {
            $this->load->helper('url');
            redirect('/home','refresh');
        }
    }

    public function project_overview()
    {
        $this->load->model('Project_model');
        $onGoingTask = $this->Project_model->get_ongoing_task($this->projectID);
        $completedTask = $this->Project_model->get_completed_task($this->projectID);
        $countedTask = $this->Project_model->get_counted_task($this->projectID);
        $highestDate = $this->Project_model->get_highest_date($this->projectID);
        if ($highestDate != null) {
            $todayDate = new DateTime('now');
            $dDiff = date_diff($todayDate, $highestDate)->format('%R%a');
            $highestDate = $highestDate->format('Y-m-d');
            $todayDate = $todayDate->format('Y-m-d');
        }

        $data = array(
            'taskOngoing' => json_encode($onGoingTask),
            'completedTask' => json_encode($completedTask),
            'countedTask' => $countedTask,
            'countedCompletedTask' => $countedTask['completedTask'],
            'highestDate' => $highestDate,
            'todayDate' => $todayDate,
            'dateDiff' => $dDiff
        );
        $this->load->view('header/project_overview_h.php');
        $this->load->view('navigation/main_nav.php');
        $this->load->view('projects/project_overview_table.php', $data);
        if($this->invitations == true)
        {
            $this->load->view('invitationNotify');
        }
        $this->load->view('footer.php');

    }

    public function task()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('Project_model');
        if($this->input->post('exportExcel') != null)
        {

            $idProject = $this->session->get_userdata()['projectID'];
            $data = $this->Project_model->get_task_to_excel($idProject);
            if($data != null)
            {
                $output = '';
                $output .= '  
                <table class="table" bordered="1">  
                     <tr>  
                          <th>Nazwa</th>  
                          <th>Data rozpoczęcia</th>  
                          <th>Data zakończenia</th>  
                          <th>Priorytet</th>  
                          <th>Budżet</th> 
                          <th>Progress</th>  
                     </tr>  
           ';
                foreach ($data as $value)
                {

                    $output .= '  
                     <tr>  
                          <td>'.$value["text"].'</td>  
                          <td>'.$value["startDate"].'</td>  
                          <td>'.$value["endDate"].'</td>  
                          <td>'.$value["priority"].'</td>  
                          <td>'.$value["budget"].'</td>  
                          <td>'.$value["progress"].'</td>    
                     </tr>  
                ';
                }
                $output .= '</table>';
                //var_dump($output);
                header("Content-Type: application/xls");
                header("Content-Disposition: attachment; filename=download.xls");
                echo "<html>";
                echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
                echo "<body>";
                echo $output;
                echo "</body>";
                echo "</html>";
            }

        }
        $data['role'] = $this->Project_model->get_user_permission_in_project($this->userID,$this->projectID);
        $data['users'] = $this->Project_model->get_users_to_task($this->projectID);
        $this->load->view('header/gantt_h.php');
        $this->load->view('navigation/main_nav.php');
        $this->load->view('projects/gantt_chart.php',$data);
        if($this->invitations == true)
        {
            $this->load->view('invitationNotify');
        }
        $this->load->view('footer.php');
    }

    public function connect_to_gatt()
    {
        $this->load->model('Gantt_connector');
        $this->Gantt_connector->connector();
    }

    public function budget()
    {

        $this->load->helper('url');
        $this->load->helper('form');

        $idProject = $this->session->get_userdata()['projectID'];
        $this->load->model('Project_model');
        $totalityBudget = array(
            'projectBgt' =>  $this->Project_model->get_project_buget($idProject),
            'wholeTaskBgt' =>  $this->Project_model->get_sum_whole_task($idProject),
            'onGoingTaskBgt' =>  $this->Project_model->get_sum_ongoing_task($idProject),
            'completedTaskBgt' => $this->Project_model->get_sum_completed_task($idProject),
            'uncompletedTaskBgt' =>  $this->Project_model->get_sum_uncompleted_task($idProject),
        );
//        var_dump( $this->Project_model->get_sum_uncompleted_task($idProject));
        $totalityBudget['projectBudget'] = $totalityBudget;
        $totalityBudget['dataTableAllTask'] = $this->Project_model->get_project_budget($idProject,null,null,"all");
        $totalityBudget['dataTableActiveTask'] = $this->Project_model->get_project_budget($idProject,null,null,'ongoing');
        $totalityBudget['dataTableUnCompletedTask'] = $this->Project_model->get_project_budget($idProject,null,true,'uncompleted');
//        $totalityBudget['dataTableUnCompletedTask'] = $this->Project_model->get_sum_uncompleted_task($idProject);
        $this->load->view('header/budget_h.php');
        $this->load->view('navigation/main_nav.php');
        $this->load->view('projects/budget.php',$totalityBudget);
//        var_dump($totalityBudget);
        if($this->invitations == true)
        {
            $this->load->view('invitationNotify');
        }
        $this->load->view('footer.php');
    }

    public function manage_hr()
    {
        $this->load->helper('url');
        $this->load->helper('form');
        $data = array();

        $this->load->model('Project_model');
        $data['division'] =  $this->Project_model->get_division_by_project($this->session->get_userdata()['projectID']);
//        var_dump($data);
        if ($this->input->post('addUserTP') != null) {
            $usrEmail = $this->input->post('userEmail');
            $targetGr = $this->input->post('group');
            $usrRole = $this->input->post('userRole');
            $idProject = $this->session->get_userdata()['projectID'];
            $this->load->model('Project_model');
            $data['st'] = $this->Project_model->check_possibility_of_invitation($this->userID, $usrEmail);
            if ($data['st']['status'] == 'true') {
                $this->Project_model->send_invitation($this->userID, $usrEmail, $targetGr, $usrRole, $idProject);
            }
        }elseif ($this->input->post('elemToRem') != null)
        {
            $selUsrToRemFProject = $this->input->post('elemToRem');
            $this->Project_model->leave_project($selUsrToRemFProject,$this->projectID);
        }
        $this->load->view('header/hr_h.php');
        $this->load->view('navigation/main_nav.php');
        $this->load->view('projects/manage_hr.php', $data);
        if($this->invitations == true)
        {
            $this->load->view('invitationNotify');
        }
        $this->load->view('footer.php');
    }

    public function test_gantt()
    {
        $this->load->helper('url');
        $this->load->view('test/gantt.php');
    }

}