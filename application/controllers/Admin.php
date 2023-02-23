<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('admin_model'));
	}
	public function dashboard()
	{
		$this->admin_model->check_auth();
		$this->load->view('admin/dashboard');
	}
	public function tables()
	{
		$this->admin_model->check_auth();
		$this->load->view('admin/tables');
	}
	public function forms()
	{
		$this->admin_model->check_auth();
		$this->load->view('admin/forms');
	}
	
}
