<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cards extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('admin_model'));
	}
	
	public function index()
	{
		$this->admin_model->check_auth();
		$data['users']	=	$this->admin_model->fetch_all_by_condition('admin_users',array('deleted'=>'0'),'*');
		$this->load->view('users/index',$data);
	}
	
	
	public function edit($user_id='')
	{
		$this->admin_model->check_auth();
		if($this->input->post()){
			$uInfo	=	array(
				'first_name'		=> $this->input->post('first_name')
			);
			$this->db->where(array('id'=>$this->input->post('user_id')));
			$this->db->update($this->db->dbprefix('admin_users'),$uInfo);
			$this->session->set_flashdata('status','Upated Successfully!!!');
			redirect("users/index","refresh");
		}else{
			$data['userInfo']	=	$this->admin_model->fetch_single_by_condition('admin_users',array('id'=>$user_id),'*');
			$this->load->view('users/edit',$data);
		}
		
	}
	public function add()
	{
		$this->admin_model->check_auth();
		if($this->input->post()){
			$uInfo	=	array(
				'first_name'		=> $this->input->post('first_name')
			);
			$this->hr_model->insert_data('admin_users', $uInfo);
			$this->session->set_flashdata('status','Added Successfully!!!');
			redirect("users/index","refresh");
		}else{
			$this->load->view('users/add');
		}
	}
	
}
