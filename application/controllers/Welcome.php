<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Welcome extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->library('user_agent');

        $agent = $this->agent->browser();
        
        if($agent != 'Chrome'){
            echo "<span style='color: red; background-color: yellow; font-size: 30px;'>Please Use Google Chrome Browser!</span>";
            die();
        }

        $user_id = $this->session->userdata('id');
        $user_name = $this->session->userdata('username');
        $access_level = $this->session->userdata('access_level');

        if($user_id != NULL && $user_name != NULL && $access_level != NULL)
        {
            redirect('Access', 'refresh');
        }
    }

	public function index()
	{
	    $data['title'] = "Login";
		$this->load->view('login', $data);
	}

	public function loginCheck(){
        $data['username'] = $this->input->post('username');
        $data['password'] = $this->input->post('password');

        $result = $this->Welcome_model->loginCheck($data);

        $res_size = sizeof($result);

        if($res_size > 0){
            $data1['id']=$result->id;
            $data1['username']=$result->username;
            $data1['access_level']=$result->access_level;
            $data1['unit_id']=$result->unit_id;
            $data1['floor_id']=$result->floor_id;

            $this->session->set_userdata($data1);

            redirect('Access','refresh');

        }
        else{
            $data['exception']='Your User Name/Password is Invalid!';
            $this->session->set_userdata($data);

            redirect('Welcome', 'refresh');
        }
    }

    public function autoDbBackup()
    {
        $this->load->library('zip');

        // Load the DB utility class
        $this->load->dbutil();

        $db_format=array('format'=>'zip', 'filename'=>'db_plan_track.sql');
        $backup=& $this->dbutil->backup($db_format);

        $dbname='backup-on-'.date('Y-m-d').'.zip';
        $save='assets/db_backup/'.$dbname;

        write_file($save, $backup);

        force_download($dbname,$backup);
    }

}
