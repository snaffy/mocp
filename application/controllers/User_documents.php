<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 14.11.2016
 * Time: 01:46
 */
class User_documents extends My_Controller
{
    protected $projectID;

    public function __construct()
    {
        parent:: __construct();
        $this->projectID = $this->session->get_userdata()['projectID'];
        if ($this->projectID == null) {
            $this->load->helper('url');
            redirect('/home', 'refresh');
        }
    }

    public function menage_file()
    {
        $this->load->view('header/elfinder_h.php');
        $this->load->view('navigation/main_nav.php');
        $this->load->view('documents/elfinder.php');
        $this->load->view('footer.php');
//        var_dump( $this->projectID);
    }

    private function ftp_mksubdirs($ftpcon,$ftpbasedir,$ftpath){
        @ftp_chdir($ftpcon, $ftpbasedir); // /var/www/uploads
        $parts = explode('/',$ftpath); // 2013/06/11/username
        foreach($parts as $part){
            if(!@ftp_chdir($ftpcon, $part)){
                ftp_mkdir($ftpcon, $part);
                ftp_chdir($ftpcon, $part);
                //ftp_chmod($ftpcon, 0777, $part);
            }
        }
    }

    public function get_elfinder_connector()
    {
        $this->load->helper('path');
        $ftp_server = "s19.hekko.pl";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        $login = ftp_login($ftp_conn, '', '');
        if (ftp_chdir($ftp_conn, "mct_uploaded")) {
            if (ftp_chdir($ftp_conn,$this->projectID))
            {
                echo "istnieje";
            }else {
                ftp_mkdir($ftp_conn,"".$this->projectID);
            }

        }
        ftp_close($ftp_conn);

        $opts = array(
            'debug' => true,
            'roots' => array(
                array(
                    'driver' => 'FTP',           // driver for accessing file system (REQUIRED)
                    'host' => '',
                    'user' => '',
                    'pass' => '',
                    'path' => '/mct_uploaded/' . $this->projectID,
                    'alias'      => 'Katalog',
                    'defaults'   => array('read' => true, 'write' => true),
                    'tmpPath'=>'tmp',
                    // more elFinder options here
                )
            )
        );
        $this->load->library('elfinder_lib', $opts);
    }

}
