<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('admin_model'));
	}
	
	public function index()	{
		if($this->input->post()){
			$LoginData = $this->admin_model->login();
			// echo '<pre/>'; print_r($LoginData); exit; 
			if($LoginData){ //echo 'IN'; exit;
				//$redirect_uri 	= 	$LoginData['role'];
				//$userID			=	$LoginData['user_id'];
				$this->session->set_userdata('admin_in',$LoginData);
              // echo $this->session->userdata['admin_in']['role_id']; echo '<br>';
              // echo '<pre/>'; print_r($_SESSION); exit;
				redirect("admin/dashboard","refresh");
			}else{
				$this->session->set_flashdata('status','Authentication Failed!!!');
				redirect("auth","refresh");
			}
		}else{
			$this->load->view('auth/login');
		}
	}
	
	public function logout(){
		$this->session->unset_userdata('admin_in');
		redirect("auth/index","refresh");
	}
	
	
}
