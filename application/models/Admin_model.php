<?php date_default_timezone_set("Asia/Kolkata");
class Admin_model extends CI_Model { 
	public function __construct()
	{
		$this->load->database();
	}
	public function login(){
		if($this->input->post()){
			$data	=	array(
				'email'		=> $this->input->post('email'),
				'password'	=> sha1($this->input->post('password')),
				'status'	=> 'active'
			);
			$query	=	$this->db->get_where($this->db->dbprefix('admin_users'),$data);
			if($query->result_array()){
				
				return $query->row_array();
			}else{
				return false;
			}			
		}
		else{
			 return false;
		}
	}
	
	public function check_auth() {
		if(isset($this->session->userdata['admin_in'])) {
			echo $this->session->userdata['admin_in']['role_id']; echo '<br>';
			echo '<pre/>'; print_r($_SESSION); exit;
		}
      #revert / check this ::at        
		// pr($this->session);
		// if(isset($this->session->userdata['admin_in']['role_id'])) {
		// 	return true;
		// }else { 
		// 	redirect("auth","refresh");
		// }
	}
	public function check_manager() {
		if(isset($this->session->userdata['manager_in']['role'])) {
			return true;
		}else { 
			redirect("portal","refresh");
		}
	}
	public function check_operator() {
		if(isset($this->session->userdata['operator_in']['role'])) {
			return true;
		}else { 
			redirect("admin","refresh");
		}
	}

	// for custom queries  ::
	// for select on index 0
	public function custquery0($query) {          
		$query = $this->db->query($query);
		$result = $query->result_array();
		// print_r($result);
		return $result[0];
	} 
	//for insert update delete
	public function custqueryiud($query) {          
		$query = $this->db->query($query);
		$result = $query->result_array();
		// print_r($result);
		// return $query;
		return $query;
	}  


	public function insert_data($tb,$array){
		if($this->db->insert($tb,$array)){
			return true;
		}else{
			return false;
		}
	}
	public function update_data($tb,$array,$where){
	   $this->db->where($where);
	   if($this->db->update($tb,$array)){
			return true;
	   }else{
			return true;
	   }
	}
	public function delete_data($tb,$where){
		$this->db->where($where);
		if($this->db->delete($tb)){
		 return true;
		}else{
		 return true;
		}
 }

	public function fetch_all_by_condition_limit_order($tb,$where,$select,$limit,$orderkey){
		$this->db->order_by($orderkey, 'DESC');
		$this->db->select($select);
		$this->db->where($where);
		$this->db->limit($limit);
		return $this->db->get($tb)->result();
	}
	public function check_duplicate($tb,$where){
		$this->db->where($where);
		return $this->db->get($tb)->num_rows();
	}
	
	public function check_unique_by_field($tb,$where,$select){
	    $this->db->distinct();
	    $this->db->select($select);
		$this->db->where($where);
		return $this->db->get($tb)->num_rows();
	}
	
	// returns single row
	public function fetch_single_by_condition($tb,$where,$select){
		$this->db->select($select);
		$this->db->where($where);
		return $this->db->get($tb)->row();
	}

	// returns multiple row
	public function fetch_all_by_condition($tb,$where,$select){
		$this->db->select($select);
		$this->db->where($where);
		return $this->db->get($tb)->result();
	}
	



	// officesetup model
	// fetch ado list
	public function fetch_adolist($where){
		$this->db->select('ado.* ,  s.title as state');
		$this->db->from('assistant_director_office AS ado');
		$this->db->join('states AS s', 's.ID = ado.state_id', 'INNER');
		$this->db->where($where);
		return $this->db->get()->result();
	}
	// fetch rwa list
	public function fetch_all_rwa($where){
		$this->db->select('rwa.* , ado.city , ado.city_code, ado.regional_office_id  ,   rdo.regional_code as rc ');
		$this->db->from('ed_working_area AS rwa');
		$this->db->join('assistant_director_office AS ado', 'ado.id = rwa.assistant_director_office_id', 'INNER');
		$this->db->join('regional_office AS rdo', 'rdo.id = ado.regional_office_id', 'INNER');
		$this->db->where($where);
		return $this->db->get()->result();
	}


	// letters


	private function _get_bundle_listings_query(){				
		//just pass false param to not put fields in	
		$this->db->select("fb.*, ro.regional_title, ro.regional_code, ado.city", false);
		$this->db->from('tt_form_bundles fb')->join('tt_regional_office ro', 'fb.regional_office_id=ro.id', 'left')->join('tt_assistant_director_office ado', 'fb.assistant_director_office_id=ado.id', 'left');
		
		//$this->db->where('ru.is_verified', 1);
	  	   
	   if($_POST['search']['value']){		   
		  $this->db->where('(ro.regional_code LIKE "%'.$_POST['search']['value'].'%" OR ado.city LIKE "%'.$_POST['search']['value'].'%" OR fb.dch_letter_no LIKE "%'.$_POST['search']['value'].'%")', null, false);
	   }
	   
	   $column_order = array('ro.regional_code', 'ado.city', 'fb.dch_letter_no', '','','','','','','fb.created', 'fb.date_of_receipt_of_form', ''); //set column field database for datatable orderable	   	
	    if(isset($_POST['order'])){
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else{
			$this->db->order_by("fb.id", "desc"); 
		}
	   	    
	}

		function select_bundle_listings(){
				/* return $this->db->query("SELECT fb.*, ro.regional_title, ro.regional_code, ado.city FROM tt_form_bundles fb LEFT JOIN tt_regional_office ro ON fb.regional_office_id=ro.id LEFT JOIN tt_assistant_director_office ado ON fb.assistant_director_office_id=ado.id ORDER BY fb.id DESC")->result_array();*/
			//echo $this->db->last_query();
			$this->_get_bundle_listings_query();
			if($_POST['length'] != -1)
					$this->db->limit($_POST['length'], $_POST['start']);
					$query = $this->db->get();
					//return $query->result();
			return $query->result_array();
	}
	
}