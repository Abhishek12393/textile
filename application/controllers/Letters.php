<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Letters extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('admin_model'));
	}
	
	public function index()	{
		$this->admin_model->check_auth();
		$data['users']	=	$this->admin_model->fetch_all_by_condition('admin_users',array('deleted'=>'0'),'*');
		$this->load->view('users/index',$data);
	}
	public function edit($user_id='')	{
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
	
	public function letter_listing(){
 
		$this->admin_model->check_auth();
		// $data['message']	=	$this->admin_model->fetch_all_by_condition('admin_users',array('deleted'=>'0'),'*');
		$data = [];
		$this->load->view('admin/letters/letter_listing',$data);

	}

		public function ajax_form_bundle_listing(){
		 

			$data = $this->admin_model->select_bundle_listings();
			print_r($data);

			$arr = [
				"draw" => $_POST['draw'], 
				"recordsTotal" => 50, 
				"recordsFiltered" => 15, 
				"data" => [
										[
											"first_name" => "Airi", 
											"last_name" => "Satou", 
											"position" => "Accountant", 
											"office" => "Tokyo", 
											"start_date" => "28th Nov 08", 
											"salary" => "$162,700" 
										], 
										[
											"first_name" => "Angelica", 
											"last_name" => "Ramos", 
											"position" => "Chief Executive Officer (CEO)", 
											"office" => "London", 
											"start_date" => "9th Oct 09", 
											"salary" => "$1,200,000" 
										], 
										[
										"first_name" => "Ashton", 
										"last_name" => "Cox", 
										"position" => "Junior Technical Author", 
										"office" => "San Francisco", 
										"start_date" => "12th Jan 09", 
										"salary" => "$86,000" 
										], 
										[
										"first_name" => "Bradley", 
										"last_name" => "Greer", 
										"position" => "Software Engineer", 
										"office" => "London", 
										"start_date" => "13th Oct 12", 
										"salary" => "$132,000" 
										], 
										[
											"first_name" => "Brenden", 
											"last_name" => "Wagner", 
											"position" => "Software Engineer", 
											"office" => "San Francisco", 
											"start_date" => "7th Jun 11", 
											"salary" => "$206,850" 
										]
									] 
			]; 	 
		 	echo json_encode($arr);
		}

	public function  addLetter(){
		// also add new letter

		$data = [];
		$this->load->view('admin/letters/add_new_bundle',$data);

	}

	public function  formBundleResult(){
		// letter listing summary 

		$data['message'] = [];
		$this->load->view('admin/letters/form_bundle_result',$data);

	}

}
