<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function get_type_name_by_id($type, $type_id = '', $field = 'name') {
        $this->db->where($type . '_id', $type_id);
        $query = $this->db->get($type);
        $result = $query->result_array();
        foreach ($result as $row)
            return $row[$field];
        //return	$this->db->get_where($type,array($type.'_id'=>$type_id))->row()->$field;	
    }

    ////////invoices/////////////
    function create_invoice() 
    {
        $data['title']              = $this->input->post('title');
        $data['invoice_number']     = $this->input->post('invoice_number');
        $data['patient_id']         = $this->input->post('patient_id');
        $data['creation_timestamp'] = $this->input->post('creation_timestamp');
        $data['due_timestamp']      = $this->input->post('due_timestamp');
        $data['vat_percentage']     = $this->input->post('vat_percentage');
        $data['discount_amount']    = $this->input->post('discount_amount');
        $data['status']             = $this->input->post('status');

        $invoice_entries            = array();
        $descriptions               = $this->input->post('entry_description');
        $amounts                    = $this->input->post('entry_amount');
        $number_of_entries          = sizeof($descriptions);
        
        for ($i = 0; $i < $number_of_entries; $i++)
        {
            if ($descriptions[$i] != "" && $amounts[$i] != "")
            {
                $new_entry          = array('description' => $descriptions[$i], 'amount' => $amounts[$i]);
                array_push($invoice_entries, $new_entry);
            }
        }
        $data['invoice_entries']    = json_encode($invoice_entries);

        $this->db->insert('invoice', $data);
    }
    
    function select_invoice_info()
    {
        return $this->db->get('invoice')->result_array();
    }
    
    function select_invoice_info_by_patient_id()
    {
        $patient_id = $this->session->userdata('login_user_id');
        return $this->db->get_where('invoice', array('patient_id' => $patient_id))->result_array();
    }

    function update_invoice($invoice_id)
    {
        $data['title']              = $this->input->post('title');
        $data['invoice_number']     = $this->input->post('invoice_number');
        $data['patient_id']         = $this->input->post('patient_id');
        $data['creation_timestamp'] = $this->input->post('creation_timestamp');
        $data['due_timestamp']      = $this->input->post('due_timestamp');
        $data['vat_percentage']     = $this->input->post('vat_percentage');
        $data['discount_amount']    = $this->input->post('discount_amount');
        $data['status']             = $this->input->post('status');

        $invoice_entries            = array();
        $descriptions               = $this->input->post('entry_description');
        $amounts                    = $this->input->post('entry_amount');
        $number_of_entries          = sizeof($descriptions);
        
        for ($i = 0; $i < $number_of_entries; $i++)
        {
            if ($descriptions[$i] != "" && $amounts[$i] != "")
            {
                $new_entry          = array('description' => $descriptions[$i], 'amount' => $amounts[$i]);
                array_push($invoice_entries, $new_entry);
            }
        }
        $data['invoice_entries']    = json_encode($invoice_entries);

        $this->db->where('invoice_id', $invoice_id);
        $this->db->update('invoice', $data);
    }

    function delete_invoice($invoice_id)
    {
        $this->db->where('invoice_id', $invoice_id);
        $this->db->delete('invoice');
    }

    function calculate_invoice_total_amount($invoice_number)
    {
        $total_amount           = 0;
        $invoice                = $this->db->get_where('invoice', array('invoice_number' => $invoice_number))->result_array();
        foreach ($invoice as $row)
        {
            $invoice_entries    = json_decode($row['invoice_entries']);
            foreach ($invoice_entries as $invoice_entry)
                $total_amount  += $invoice_entry->amount;

            $vat_amount         = $total_amount * $row['vat_percentage'] / 100;
            $grand_total        = $total_amount + $vat_amount - $row['discount_amount'];
        }

        return $grand_total;
    }

  

    //////system settings//////
    function update_system_settings() {
        $data['description'] = $this->input->post('system_name');
        $this->db->where('type', 'system_name');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_title');
        $this->db->where('type', 'system_title');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('address');
        $this->db->where('type', 'address');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('phone');
        $this->db->where('type', 'phone');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('paypal_email');
        $this->db->where('type', 'paypal_email');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_currency_id');
        $this->db->where('type', 'system_currency_id');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_email');
        $this->db->where('type', 'system_email');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('buyer');
        $this->db->where('type', 'buyer');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('system_name');
        $this->db->where('type', 'system_name');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('purchase_code');
        $this->db->where('type', 'purchase_code');
        $this->db->update('settings', $data);

        $data['description'] = $this->input->post('language');
        $this->db->where('type', 'language');
        $this->db->update('settings', $data);
        $this->session->set_userdata('current_language' , $this->input->post('language'));

        $data['description'] = $this->input->post('text_align');
        $this->db->where('type', 'text_align');
        $this->db->update('settings', $data);
    }

    /////creates log/////
    function create_log($data) {
        $data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
        $data['location'] = $location->City . ' , ' . $location->CountryName;
        $this->db->insert('log', $data);
    }

    ////////BACKUP RESTORE/////////
    function create_backup($type) {
        $this->load->dbutil();


        $options = array(
            'format' => 'txt', // gzip, zip, txt
            'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n"               // Newline character used in backup file
        );


        if ($type == 'all') {
            $tables = array('');
            $file_name = 'system_backup';
        } else {
            $tables = array('tables' => array($type));
            $file_name = 'backup_' . $type;
        }

        $backup = & $this->dbutil->backup(array_merge($options, $tables));


        $this->load->helper('download');
        force_download($file_name . '.sql', $backup);
    }

    /////////RESTORE TOTAL DB/ DB TABLE FROM UPLOADED BACKUP SQL FILE//////////
    function restore_backup() {
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/backup.sql');
        $this->load->dbutil();


        $prefs = array(
            'filepath' => 'uploads/backup.sql',
            'delete_after_upload' => TRUE,
            'delimiter' => ';'
        );
        $restore = & $this->dbutil->restore($prefs);
        unlink($prefs['filepath']);
    }

    /////////DELETE DATA FROM TABLES///////////////
    function truncate($type) {
        if ($type == 'all') {
            $this->db->truncate('student');
            $this->db->truncate('mark');
            $this->db->truncate('teacher');
            $this->db->truncate('subject');
            $this->db->truncate('class');
            $this->db->truncate('exam');
            $this->db->truncate('grade');
        } else {
            $this->db->truncate($type);
        }
    }

    ////////IMAGE URL//////////
    function get_image_url($type = '', $id = '') {
        if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg'))
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = base_url() . 'uploads/user.jpg';

        return $image_url;
    }
    ///////////////////////////////////////////////////Textile India/////////////////////////////////
    function save_ministry_of_department()
    {
        $data['regional_title'] = trim($this->input->post('regional_title'));
				$data['regional_code'] = trim($this->input->post('regional_code'));		
				$data['admin_created_by'] = $this->session->userdata('login_user_id');
				
						return $this->db->insert('tt_regional_office',$data);
    }
	
	function update_ministry_of_department()
    {
        $data['regional_title'] = trim($this->input->post('regional_title'));
		$data['regional_code'] = trim($this->input->post('regional_code'));		
		$data['admin_updated_by'] = $this->session->userdata('login_user_id');
		$id = trim($this->input->post('id'));
        $this->db->where('id',$id);
        return $this->db->update('tt_regional_office',$data);
    }
	
	function save_director_office()
    {
        
		//save signature image
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		//file upload
		$thumb_image_name = NULL;
		$uploaded_file_name = NULL;
		if(isset($_FILES['image']) and !empty($_FILES['image']['name'])){							
			
			$original = 'uploads/user_image/assistant_director_signature/original/';
				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 2048;	 //in KB
			
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			
			if ( ! $this->upload->do_upload('image')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "");				
				echo json_encode($ar);
				exit;
												
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$uploaded_file_name = addslashes($uploaded_data['upload_data']['file_name']);				
				
				//$ar = getimagesize("home.png");
				//OUTPUT
				/*Array
				(
					[0] => 1366
					[1] => 768
					[2] => 3
					[3] => width="1366" height="768"
					[bits] => 8
					[mime] => image/png
				)*/
				
				//
				$thumb = 	'uploads/user_image/assistant_director_signature/thumb/';	
				$image_info_ar = getimagesize($original.$uploaded_file_name);						
				$this->load->library('image_lib');
				$configa['image_library'] = 'gd2';
				$configa['source_image'] = $original.$uploaded_file_name;       
				$configa['create_thumb'] = TRUE;
				$configa['maintain_ratio'] = TRUE;
				$configa['width'] = 140;
				$configa['height'] = 25;
				$configa['thumb_marker'] = false;
				$thumb_image_name = "thumb_".microtime().$uploaded_file_name;
				$configa['new_image'] = $thumb.$thumb_image_name;
				$this->image_lib->initialize($configa);
				if(!$this->image_lib->resize())
				{ 
					//echo $this->image_lib->display_errors();
					$ar = array("status" => "fail", "error" => $this->image_lib->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "");
					echo json_encode($ar);
					exit;	
				}				
			}
		}else{
			$ar = array("status" => "fail", "error" => "Please upload Assistant Director Signature.", "frm_btn_id" => $submit_btn_id, "redirect" => "");
				echo json_encode($ar);
				exit;
		}
		 
		$data['office_head_signature'] = $uploaded_file_name; 
		$data['office_head_signature_thumb'] = $thumb_image_name;
				
		
		$data['regional_office_id'] = trim($this->input->post('regional_office_id'));
		$data['office_head_name'] = trim($this->input->post('office_head_name'));
		$data['country_id'] = trim($this->input->post('country_id'));
		$data['state_id'] = trim($this->input->post('state_id'));
		$data['city'] = trim($this->input->post('city'));
		$data['pin_code'] = trim($this->input->post('pin_code'));
		$data['city_code'] = trim($this->input->post('city_code'));
		$data['address1'] = trim($this->input->post('address1'));
		$data['address2'] = trim($this->input->post('email'));
		$data['admin_created_by'] = $this->session->userdata('login_user_id');
        return $this->db->insert('tt_assistant_director_office',$data);
    }
	
	function update_director_office()
    {
        
		//save signature image
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		//file upload
		$thumb_image_name = NULL;
		$uploaded_file_name = NULL;
		if(isset($_FILES['image']) and !empty($_FILES['image']['name'])){							
			
			$original = 'uploads/user_image/assistant_director_signature/original/';
				
			$configsd['upload_path']          = $original;			
			$configsd['allowed_types']        = 'jpg|png|jpeg';
			$configsd['max_size']             = 2048;	 //in KB
			
			$this->load->library('upload');
			$this->upload->initialize($configsd);
			
			if ( ! $this->upload->do_upload('image')){					
				$ar = array("status" => "fail", "error" => $this->upload->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "");				
				echo json_encode($ar);
				exit;
												
			}else{
				$uploaded_data = array('upload_data' => $this->upload->data());	
				$uploaded_file_name = addslashes($uploaded_data['upload_data']['file_name']);				
				
				//$ar = getimagesize("home.png");
				//OUTPUT
				/*Array
				(
					[0] => 1366
					[1] => 768
					[2] => 3
					[3] => width="1366" height="768"
					[bits] => 8
					[mime] => image/png
				)*/
				
				//
				$thumb = 	'uploads/user_image/assistant_director_signature/thumb/';	
				$image_info_ar = getimagesize($original.$uploaded_file_name);						
				$this->load->library('image_lib');
				$configa['image_library'] = 'gd2';
				$configa['source_image'] = $original.$uploaded_file_name;       
				$configa['create_thumb'] = TRUE;
				$configa['maintain_ratio'] = TRUE;
				$configa['width'] = 168;
				$configa['height'] = 50;
				$configa['thumb_marker'] = false;
				$thumb_image_name = "thumb_".microtime().$uploaded_file_name;
				$configa['new_image'] = $thumb.$thumb_image_name;
				$this->image_lib->initialize($configa);
				if(!$this->image_lib->resize())
				{ 
					//echo $this->image_lib->display_errors();
					$ar = array("status" => "fail", "error" => $this->image_lib->display_errors(), "frm_btn_id" => $submit_btn_id, "redirect" => "");
					echo json_encode($ar);
					exit;	
				}				
			}
		}
		 
		//no need to delete old image
		if($uploaded_file_name){
			$data['office_head_signature'] = $uploaded_file_name; 
			$data['office_head_signature_thumb'] = $thumb_image_name;
		}
			
		$data['regional_office_id'] = trim($this->input->post('regional_office_id'));
		$data['office_head_name'] = trim($this->input->post('office_head_name'));
		$data['state_id'] = trim($this->input->post('state_id'));
		$data['city'] = trim($this->input->post('city'));
		$data['city_code'] = trim($this->input->post('city_code'));
		$data['pin_code'] = trim($this->input->post('pin_code'));
		$data['address1'] = trim($this->input->post('address1'));
		$data['address2'] = trim($this->input->post('email'));
		$data['admin_updated_by'] = $this->session->userdata('login_user_id');
		$id = trim($this->input->post('id'));
        $this->db->where('id',$id);
        return $this->db->update('tt_assistant_director_office',$data);
    }
    
    function select_regional_office()
    {
        return $this->db->get('tt_regional_office')->result_array();
    }
	
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
	
	function count_filtered_bundle_listings(){
		$this->_get_bundle_listings_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_bundle_listings(){        
		$this->_get_bundle_listings_query();
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	//select bundle listings for id card addition
	 function select_bundle_listings_for_add_card(){
		 if($this->session->userdata('role_id')<=2){
			 return $this->db->query("SELECT fb.*, ro.regional_title, ro.regional_code, ado.city FROM tt_form_bundles fb LEFT JOIN tt_regional_office ro ON fb.regional_office_id=ro.id LEFT JOIN tt_assistant_director_office ado ON fb.assistant_director_office_id=ado.id ORDER BY fb.id DESC")->result_array();
		 }else{
			 if($this->session->userdata('has_access_all_region')>0){
				  return $this->db->query("SELECT fb.*, ro.regional_title, ro.regional_code, ado.city FROM tt_form_bundles fb LEFT JOIN tt_regional_office ro ON fb.regional_office_id=ro.id LEFT JOIN tt_assistant_director_office ado ON fb.assistant_director_office_id=ado.id ORDER BY fb.id DESC")->result_array();
			 }else{
				$access_region_str = implode(',',json_decode($this->session->userdata('access_region_str')));				
				return $this->db->query("SELECT fb.*, ro.regional_title, ro.regional_code, ado.city FROM tt_form_bundles fb LEFT JOIN tt_regional_office ro ON fb.regional_office_id=ro.id LEFT JOIN tt_assistant_director_office ado ON fb.assistant_director_office_id=ado.id WHERE 1=1 AND fb.regional_office_id IN($access_region_str) ORDER BY fb.id DESC")->result_array();
			 }
		 }    
		
    }
	
	//get bundle details
	 function get_bundle_details($id)
    {
        return $this->db->query("SELECT fb.*, ro.regional_title, ro.regional_code, ado.city, ado.city_code, ado.state_id, s.title as state_title, ed.title as ed_title, ed.code as ed_code FROM tt_form_bundles fb LEFT JOIN tt_regional_office ro ON fb.regional_office_id=ro.id LEFT JOIN tt_assistant_director_office ado ON fb.assistant_director_office_id=ado.id LEFT JOIN tt_ed_working_area ed ON fb.ed_working_area_id=ed.id LEFT JOIN tt_states s ON ado.state_id=s.id WHERE 1=1 AND fb.id='".$this->db->escape_str($id)."'")->row();
    }
	
	private function _get_id_card_listings_step_one_query($bundle_id = NULL){
		$this->db->select('ru.id, ru.regional_office_id, ru.assistant_director_office_id, ru.form_bundle_id, ru.original_user_photo, ru.original_signature, ru.complete_form_file, ru.created, ro.regional_title, ro.regional_code, ado.city, ado.city_code');
       if($this->session->userdata('role_id')<=2){
		   	$this->db->from('tt_registered_users ru')->join('tt_regional_office ro', 'ru.regional_office_id=ro.id', 'left')->join('tt_assistant_director_office ado', 'ru.assistant_director_office_id=ado.id', 'left');
			if($bundle_id){
				$this->db->where('ru.form_bundle_id', $bundle_id);
			}
			
	   }else{
		   if($this->session->userdata('has_access_all_region')>0){
				$this->db->from('tt_registered_users ru')->join('tt_regional_office ro', 'ru.regional_office_id=ro.id', 'left')->join('tt_assistant_director_office ado', 'ru.assistant_director_office_id=ado.id', 'left');
				if($bundle_id){
					$this->db->where('ru.form_bundle_id', $bundle_id);
				}				
		   }else{
				$this->db->from('tt_registered_users ru')->join('tt_regional_office ro', 'ru.regional_office_id=ro.id', 'left')->join('tt_assistant_director_office ado', 'ru.assistant_director_office_id=ado.id', 'left');
				
				if($bundle_id){
					$this->db->where('ru.form_bundle_id', $bundle_id);
				} 
				$access_region_ar = json_decode($this->session->userdata('access_region_str'));
				$this->db->where_in('ru.regional_office_id', $access_region_ar);
				
		   }
		   
		   //verified entry is not required to display for resource		   
		   	$this->db->where("ru.is_verified <>", 1);
		   
	   }
	   
	  	   
	   if($_POST['search']['value']){
		   //$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
           //$this->db->like('ro.regional_title', $_POST['search']['value']);
		  // $this->db->or_like('ado.city', $_POST['search']['value']);
		  // $this->db->group_end(); //close bracket
		  $this->db->where('(ro.regional_title LIKE "%'.$_POST['search']['value'].'%" OR ado.city LIKE "%'.$_POST['search']['value'].'%")', null, false);
	   }
	   
	   $column_order = array('ro.regional_title','ado.city','','','','ru.created'); //set column field database for datatable orderable	   	
	    if(isset($_POST['order'])){
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else{
			$this->db->order_by("ru.id", "asc"); 
		}
	   	    
	}
	
	function count_filtered_step_one($bundle_id){
		$this->_get_id_card_listings_step_one_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_step_one($bundle_id = NULL){        
		$this->_get_id_card_listings_step_one_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	function select_id_card_listings($bundle_id = NULL)
    { 				
		$this->_get_id_card_listings_step_one_query($bundle_id);
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        //return $query->result();
		return $query->result_array();
		
    }
			
	function select_id_card_listings_for_data_entry($bundle_id = NULL)
    {        
		//now need to show only assigned user for entry
		$qrystr = "";
		if($bundle_id){
			$qrystr = " AND ru.form_bundle_id='".$bundle_id."' ";
		}
				
		$qrystr .= " AND ru.submitted_by_data_entry_id=0 AND ru.id IN(SELECT DISTINCT(registered_user_id) FROM tt_registered_user_assigned WHERE 1=1 AND admin_user_id='".$this->session->userdata('login_user_id')."') ";
		
		if($this->session->userdata('role_id')<=2){
			return $this->db->query("SELECT ru.*, ro.regional_title, ro.regional_code, ado.city, ado.city_code, fb.dch_letter_no FROM tt_registered_users ru LEFT JOIN  tt_regional_office ro ON ru.regional_office_id=ro.id LEFT JOIN tt_assistant_director_office ado ON ru.assistant_director_office_id=ado.id LEFT JOIN tt_form_bundles fb ON ru.form_bundle_id=fb.id  WHERE 1=1 $qrystr ORDER BY ru.id ASC")->result_array();
		}else{
			if($this->session->userdata('has_access_all_region')>0){
				return $this->db->query("SELECT ru.*, ro.regional_title, ro.regional_code, ado.city, ado.city_code, fb.dch_letter_no FROM tt_registered_users ru LEFT JOIN  tt_regional_office ro ON ru.regional_office_id=ro.id LEFT JOIN tt_assistant_director_office ado ON ru.assistant_director_office_id=ado.id LEFT JOIN tt_form_bundles fb ON ru.form_bundle_id=fb.id  WHERE 1=1 $qrystr ORDER BY ru.id ASC")->result_array();
			}else{
				$access_region_str = implode(',',json_decode($this->session->userdata('access_region_str')));
				return $this->db->query("SELECT ru.*, ro.regional_title, ro.regional_code, ado.city, ado.city_code, fb.dch_letter_no FROM tt_registered_users ru LEFT JOIN  tt_regional_office ro ON ru.regional_office_id=ro.id LEFT JOIN tt_assistant_director_office ado ON ru.assistant_director_office_id=ado.id LEFT JOIN tt_form_bundles fb ON ru.form_bundle_id=fb.id  WHERE 1=1 $qrystr AND ru.regional_office_id IN($access_region_str) ORDER BY ru.id ASC")->result_array();		
			}
		}
		
    }
	
	function get_cards_for_assign_to_staff($limit)
    {        
		//now need to show only assigned user for entry
		$qrystr = "";	
		//not allow to fetch if any staff has assigned any card					
		$qrystr .= " AND ru.submitted_by_data_entry_id=0 AND ru.id NOT IN(SELECT registered_user_id FROM tt_registered_user_assigned) ";
		
		$limitstr = "";
		if($limit){
			$limitstr = " LIMIT ".$limit." ";
		}
				
		if($this->session->userdata('role_id')<=2){
			return $this->db->query("SELECT ru.id FROM tt_registered_users ru WHERE 1=1 $qrystr ORDER BY ru.id ASC $limitstr")->result_array();
		}else{
			if($this->session->userdata('has_access_all_region')>0){
				return $this->db->query("SELECT ru.id FROM tt_registered_users ru WHERE 1=1 $qrystr ORDER BY ru.id ASC $limitstr")->result_array();
			}else{
				$access_region_str = implode(',',json_decode($this->session->userdata('access_region_str')));
				return $this->db->query("SELECT ru.id FROM tt_registered_users ru WHERE 1=1 $qrystr AND ru.regional_office_id IN($access_region_str) ORDER BY ru.id ASC $limitstr")->result_array();		
			}
		}
		
    }	
	
	function unverified_id_card_listings()
    {        
		//is_verified: 1 if verified by verification team
		//submitted_by_data_entry_id: id of data entry user id who has done data entry
		return $this->db->query("SELECT ru.*, ro.regional_title, ro.regional_code, ado.city, ado.city_code FROM tt_registered_users ru LEFT JOIN  tt_regional_office ro ON ru.regional_office_id=ro.id LEFT JOIN tt_assistant_director_office ado ON ru.assistant_director_office_id=ado.id LEFT JOIN tt_registered_user_unverified_assigned ruua ON ru.id=ruua.registered_user_id  WHERE 1=1 AND ru.submitted_by_data_entry_id>0 AND ru.is_verified=0 AND ru.id IN(SELECT DISTINCT registered_user_id FROM  tt_registered_user_unverified_assigned where 1=1 and admin_user_id='".$this->session->userdata('login_user_id')."') ORDER BY ru.id ASC")->result_array();
		//echo $this->db->last_query();
    }
	
	function get_unverified_cards_for_assign_to_staff($limit)
    {        
		//now need to show only assigned user for entry
		$qrystr = "";	
		//not allow to fetch if any staff has assigned any card					
		$qrystr .= " AND ru.submitted_by_data_entry_id>0 AND ru.is_verified=0 AND ru.id NOT IN(SELECT registered_user_id FROM tt_registered_user_unverified_assigned) ";
		
		$limitstr = "";
		if($limit){
			$limitstr = " LIMIT ".$limit." ";
		}
		
		//below commented condion is not for verify		
	/*	if($this->session->userdata('role_id')<=2){
			return $this->db->query("SELECT ru.id FROM tt_registered_users ru WHERE 1=1 $qrystr ORDER BY ru.id ASC $limitstr")->result_array();
		}else{
			if($this->session->userdata('has_access_all_region')>0){
				return $this->db->query("SELECT ru.id FROM tt_registered_users ru WHERE 1=1 $qrystr ORDER BY ru.id ASC $limitstr")->result_array();
			}else{
				$access_region_str = implode(',',json_decode($this->session->userdata('access_region_str')));
				return $this->db->query("SELECT ru.id FROM tt_registered_users ru WHERE 1=1 $qrystr AND ru.regional_office_id IN($access_region_str) ORDER BY ru.id ASC $limitstr")->result_array();		
			}
		}*/
				
		return $this->db->query("SELECT ru.id FROM tt_registered_users ru WHERE 1=1 and original_user_photo!='' and original_signature!='' and 	complete_form_file!='' $qrystr ORDER BY ru.id ASC $limitstr")->result_array();
		
    }
	
	private function _get_verified_id_card_listings_query($bundle_id = NULL){				
		//just pass false param to not put fields in ``
		$this->db->select("ru.id, ru.regional_office_id, ru.assistant_director_office_id, ru.regional_office_code, ru.assistant_director_office_code, ru.generated_id_card_no, ru.form_bundle_id, ru.form_no, ru.original_user_photo, ru.thumb_user_photo, ru.original_signature, ru.thumb_signature, ru.complete_form_file, ru.en_artisian_first_name, ru.created, CASE WHEN ru.is_verified=1 THEN 'Verified' WHEN ru.is_verified=2 THEN 'Rejected' WHEN ru.is_verified=0 THEN 'Un-verified' END AS card_status, ru.is_verified, ro.regional_title, ro.regional_code, ado.city, ado.city_code", false);
		$this->db->from('tt_registered_users ru')->join('tt_regional_office ro', 'ru.regional_office_id=ro.id', 'left')->join('tt_assistant_director_office ado', 'ru.assistant_director_office_id=ado.id', 'left');
		if($bundle_id){
			$this->db->where('ru.form_bundle_id', $bundle_id);
		}
		$this->db->where('ru.is_verified', 1);
	  	   
	   if($_POST['search']['value']){		   
		  $this->db->where('(ro.regional_title LIKE "%'.$_POST['search']['value'].'%" OR ado.city LIKE "%'.$_POST['search']['value'].'%")', null, false);
	   }
	   
	   $column_order = array('ru.generated_id_card_no', 'ru.is_verified', 'ru.regional_office_code', 'ado.city','','','ru.created', ''); //set column field database for datatable orderable	   	
	    if(isset($_POST['order'])){
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else{
			$this->db->order_by("ru.generated_id_card_no", "asc"); 
		}
	   	    
	}
	
	function verified_id_card_listings()
    {       
		
		//echo $this->db->last_query();
		$this->_get_verified_id_card_listings_query($bundle_id);
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        //return $query->result();
		return $query->result_array();
    }
	
	function count_filtered_verified_listings($bundle_id){
		$this->_get_verified_id_card_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_verified_listings($bundle_id = NULL){        
		$this->_get_verified_id_card_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	private function _get_rejected_id_card_listings_query($bundle_id = NULL){				
		//just pass false param to not put fields in ``
		$this->db->select("ru.id, ru.regional_office_id, ru.assistant_director_office_id, ru.regional_office_code, ru.assistant_director_office_code, ru.generated_id_card_no, ru.form_bundle_id, ru.form_no, ru.original_user_photo, ru.thumb_user_photo, ru.original_signature, ru.thumb_signature, ru.complete_form_file, ru.en_artisian_first_name, ru.created, CASE WHEN ru.is_verified=1 THEN 'Verified' WHEN ru.is_verified=2 THEN 'Rejected' WHEN ru.is_verified=0 THEN 'Un-verified' END AS card_status, ru.is_verified, ro.regional_title, ro.regional_code, ado.city, ado.city_code", false);
		$this->db->from('tt_registered_users ru')->join('tt_regional_office ro', 'ru.regional_office_id=ro.id', 'left')->join('tt_assistant_director_office ado', 'ru.assistant_director_office_id=ado.id', 'left');
		if($bundle_id){
			$this->db->where('ru.form_bundle_id', $bundle_id);
		}
		//rejected: 2 
		$this->db->where('ru.is_verified', 2);
	  	   
	   if($_POST['search']['value']){		   
		  $this->db->where('(ro.regional_title LIKE "%'.$_POST['search']['value'].'%" OR ado.city LIKE "%'.$_POST['search']['value'].'%")', null, false);
	   }
	   
	   $column_order = array('', 'ru.is_verified', 'ru.regional_office_code', 'ado.city','','','ru.created', ''); //set column field database for datatable orderable	   	
	    if(isset($_POST['order'])){
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else{
			$this->db->order_by("ru.id", "asc"); 
		}
	   	    
	}
	
	function rejected_id_card_listings()
    {       
		
		//echo $this->db->last_query();
		$this->_get_rejected_id_card_listings_query($bundle_id);
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        //return $query->result();
		return $query->result_array();
    }
	
	function count_filtered_rejected_listings($bundle_id){
		$this->_get_rejected_id_card_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_rejected_listings($bundle_id = NULL){        
		$this->_get_rejected_id_card_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	//Generating ID Card Listings
	private function _get_generating_pdf_id_card_listings_query(){				
		//just pass false param to not put fields in ``
		$this->db->select("ru.id, ru.generated_id_card_no", false);
		//$this->db->from('tt_registered_users ru')->join('tt_regional_office ro', 'ru.regional_office_id=ro.id', 'left')->join('tt_assistant_director_office ado', 'ru.assistant_director_office_id=ado.id', 'left');
		$this->db->from('tt_registered_users ru')->join('tt_form_bundles fb', 'ru.form_bundle_id=fb.id', 'left');
				
		//verified: 1
		$this->db->where('ru.is_verified', 1);
		$region_id = $this->db->escape_str(trim($_POST['region_id']));
		$letter_no = $this->db->escape_str(trim($_POST['letter_no']));
		$id_from = $this->db->escape_str(trim($_POST['id_from']));
		$id_to = $this->db->escape_str(trim($_POST['id_to']));
		$multi_ids = $this->db->escape_str(trim($_POST['multi_ids']));
		if($region_id){
			$this->db->where('ru.regional_office_id', $region_id);
		}
		if($letter_no){
			$this->db->where('fb.dch_letter_no', $letter_no);
		}
		
		if($id_from and $id_to){
			$this->db->where("ru.generated_id_card_no BETWEEN $id_from AND $id_to");
		}
		
		if($multi_ids){
			$this->db->where("ru.generated_id_card_no IN ($multi_ids)");
		}
		
	    $this->db->order_by("ru.generated_id_card_no", "asc"); 
	   	    
	}
	
	function generating_pdf_id_card_listings()
    {	
		$this->_get_generating_pdf_id_card_listings_query();
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        //return $query->result();
		return $query->result_array();
    }
	
	function count_filtered_generating_listings(){
		$this->_get_generating_pdf_id_card_listings_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_generating_pdf_listings(){        
		$this->_get_generating_pdf_id_card_listings_query();
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	//release form
	function release_un_submittedid_card_listings()
    {		
		$this->db->select("ru.id, ru.regional_office_code, ru.assistant_director_office_code, ru.created as form_added_date, ru.form_bundle_id as form_number, au.first_name, au.last_name, au.email, rua.created as form_received_date", false);
		$this->db->from('tt_registered_users ru')->join('tt_registered_user_assigned rua', 'ru.id=rua.registered_user_id', 'inner')->join('tt_admin_users au', 'rua.admin_user_id=au.id', 'inner');		
		$this->db->where('ru.submitted_by_data_entry_id', 0);
		if($_POST['search']['value']){
			//$ddd=$_POST['search']['value'];
			//$letter_about = $this->db->query("SELECT * from tt_form_bundles WHERE 1=1 AND dch_letter_no='".trim($ddd)."'")->row();
			//$letterNo = $letter_about->id;
		  $this->db->where('(ru.regional_office_code LIKE "%'.$_POST['search']['value'].'%" OR ru.assistant_director_office_code LIKE "%'.$_POST['search']['value'].'%" OR ru.form_bundle_id = "'.$_POST['search']['value'].'")', null, false);
	   }
		$this->db->order_by("rua.created", "desc");
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();       
		return $query->result_array();
    }
	
	function count_all_release_un_submitted_listings(){
		return $this->db->query("SELECT ru.id, ru.regional_office_code, ru.assistant_director_office_code, ru.created as form_added_date, au.first_name, au.last_name, au.email, rua.created as form_received_date FROM tt_registered_users ru INNER JOIN  tt_registered_user_assigned rua ON ru.id=rua.registered_user_id INNER JOIN tt_admin_users au ON rua.admin_user_id=au.id WHERE 1=1 AND ru.submitted_by_data_entry_id=0 ")->num_rows();
	}
	
	function count_filterred_release_un_submitted_listings(){
		return $this->db->query("SELECT ru.id, ru.regional_office_code, ru.assistant_director_office_code, ru.created as form_added_date, au.first_name, au.last_name, au.email, rua.created as form_received_date FROM tt_registered_users ru INNER JOIN  tt_registered_user_assigned rua ON ru.id=rua.registered_user_id INNER JOIN tt_admin_users au ON rua.admin_user_id=au.id WHERE 1=1 AND ru.submitted_by_data_entry_id=0 ")->num_rows();
	}
	
	//Release verification data
	function release_release_verification_card_listings()
    {		
		$this->db->select("ru.id, ru.regional_office_code, ru.assistant_director_office_code, ru.created as form_added_date, ru.form_bundle_id as form_number, au.first_name, au.last_name, au.email, rua.created as form_received_date", false);
		$this->db->from('tt_registered_users ru')->join('tt_registered_user_unverified_assigned rua', 'ru.id=rua.registered_user_id', 'inner')->join('tt_admin_users au', 'rua.admin_user_id=au.id', 'inner');		
		$this->db->where('ru.is_verified', 0);
		if($_POST['search']['value']){
			//$ddd=$_POST['search']['value'];
			//$letter_about = $this->db->query("SELECT * from tt_form_bundles WHERE 1=1 AND dch_letter_no='".trim($ddd)."'")->row();
			//$letterNo = $letter_about->id;
		  $this->db->where('(ru.regional_office_code LIKE "%'.$_POST['search']['value'].'%" OR ru.assistant_director_office_code LIKE "%'.$_POST['search']['value'].'%" OR ru.form_bundle_id = "'.$_POST['search']['value'].'")', null, false);
	   }
		$this->db->order_by("rua.created", "desc"); 
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();       
		return $query->result_array();
    }
	
	function count_all_release_verification_listings(){
		return $this->db->query("SELECT ru.id, ru.regional_office_code, ru.assistant_director_office_code, ru.created as form_added_date, au.first_name, au.last_name, au.email, rua.created as form_received_date FROM tt_registered_users ru INNER JOIN  tt_registered_user_unverified_assigned rua ON ru.id=rua.registered_user_id INNER JOIN tt_admin_users au ON rua.admin_user_id=au.id WHERE 1=1 AND ru.is_verified=0 ")->num_rows();
	}
	
	function count_filterred_release_verification_listings(){
		return $this->db->query("SELECT ru.id, ru.regional_office_code, ru.assistant_director_office_code, ru.created as form_added_date, au.first_name, au.last_name, au.email, rua.created as form_received_date FROM tt_registered_users ru INNER JOIN  tt_registered_user_unverified_assigned rua ON ru.id=rua.registered_user_id INNER JOIN tt_admin_users au ON rua.admin_user_id=au.id WHERE 1=1 AND ru.is_verified=0 ")->num_rows();
	}	
	//End verification form
	
	function select_admin_users()
    {
        return $this->db->query('SELECT * FROM tt_admin_users where 1=1 and role_id	!=1 and deleted=0  ORDER BY id')->result_array();
    }
    
	 function select_director_office()
    {
        //return $this->db->get('tt_assistant_director_office')->result_array();
		return $this->db->query("SELECT ado.*, ro.regional_code, s.title as state_name FROM tt_assistant_director_office ado LEFT JOIN tt_regional_office ro ON ado.regional_office_id=ro.id LEFT JOIN tt_states s ON ado.state_id=s.id  WHERE 1=1")->result_array();
    }
	
	//ed working area
	function select_ed_working_area_list(){
        //return $this->db->get('tt_assistant_director_office')->result_array();
		return $this->db->query("SELECT ed.*, ado.city, ado.city_code, ro.regional_code FROM  tt_ed_working_area ed LEFT JOIN  tt_assistant_director_office ado ON ed.assistant_director_office_id=ado.id LEFT JOIN tt_regional_office ro ON ado.regional_office_id=ro.id WHERE 1=1 ORDER BY ed.id DESC")->result_array();
    }
    		
	function update_admin_user()
    {
        $regional_office_id = trim($this->input->post('regional_office_id'));
		$assistant_director_office_id = trim($this->input->post('assistant_director_office_id'));
		$username = trim($this->input->post('username'));
		$email = trim($this->input->post('email'));
		$password = trim($this->input->post('password'));
		$first_name = trim($this->input->post('first_name'));
		$last_name = trim($this->input->post('last_name'));
		$birthdate = trim($this->input->post('birthdate'));
		$gender = trim($this->input->post('gender'));
		$mobile_phone = trim($this->input->post('mobile_phone'));
		$state_id = trim($this->input->post('state_id'));
		$city = trim($this->input->post('city'));
		$zip_code = trim($this->input->post('zip_code'));
		$address = trim($this->input->post('address'));	
		$data['role_id'] = trim($this->input->post('role_id'));
		$data['admin_updated_by'] = $this->session->userdata('login_user_id');
		$id = trim($this->input->post('id'));
        $this->db->where('id',$id);
        return $this->db->update('tt_admin_users',$data);
    }
	
	//pagination for export data
	private function _get_export_verified_pdf_id_card_listings_query(){				
		//just pass false param to not put fields in ``
		$this->db->select("ru.id, ru.generated_id_card_no", false);		
		$this->db->from('tt_registered_users ru');
				
		//verified: 1
		$this->db->where('ru.is_verified', 1);
		
		
		/*if($id_from and $id_to){
			$this->db->where("ru.generated_id_card_no BETWEEN $id_from AND $id_to");
		}*/
	  	   
	   /*if($_POST['search']['value']){		   
		  $this->db->where('(ro.regional_title LIKE "%'.$_POST['search']['value'].'%" OR ado.city LIKE "%'.$_POST['search']['value'].'%")', null, false);
	   }*/
	   
	   $this->db->order_by("ru.regional_office_code", "asc"); 
	   $this->db->order_by("ru.generated_id_card_no", "asc"); 
	   	    
	}
	
	function export_verified_id_card_listings()
    {	
		$this->_get_export_verified_pdf_id_card_listings_query();
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        //return $query->result();
		return $query->result_array();
    }
	
	function count_filtered_export_verified_listings(){
		$this->_get_export_verified_pdf_id_card_listings_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_export_verified_listings(){        
		$this->_get_export_verified_pdf_id_card_listings_query();
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	//End pagination for export verified data
			 
    
   /* function delete_medicine_info($medicine_id)
    {
        $this->db->where('medicine_id',$medicine_id);
        $this->db->delete('medicine');
    }*/
	
	///////////////////////////////////////////REPORT SECTION START by ADITYA///////////
	
		
	 function select_admin_detail_users($id)
        {
            return $this->db->query("SELECT id,en_artisian_first_name,mobile_no, date_of_birth, en_village_town_city, generated_id_card_no, data_entry_submitted_date FROM tt_registered_users where 1=1 and  submitted_by_data_entry_id='".$id."' ")->result_array();
        }
		
	function search_admin_detail_users($id=NULL,$start_date=NULL,$end_date=NULL,$admin_srch_opt=NULL)
    {
	   if($admin_srch_opt=='0'){
        return $this->db->query("SELECT id,en_artisian_first_name,mobile_no, date_of_birth, en_village_town_city, generated_id_card_no, data_entry_submitted_date FROM tt_registered_users where 1=1 and data_entry_submitted_date >= '".$start_date."' AND  data_entry_submitted_date <= '".$end_date."' and submitted_by_data_entry_id='".$id."'")->result_array();
		}
		 if($admin_srch_opt=='1'){
		 	 return $this->db->query("SELECT * FROM tt_registered_users where 1=1 and verified_date >= '".$start_date."' AND  verified_date <= '".$end_date."' and admin_verified_by='".$id."' and is_verified=1")->result_array();
		 
		 }
		 if($admin_srch_opt=='2'){
		  	 return $this->db->query("SELECT * FROM tt_registered_users where 1=1 and verified_date >= '".$start_date."' AND  verified_date <= '".$end_date."' and admin_verified_by='".$id."' and is_verified=2")->result_array();
		 }
		
    }

       //////Search section start/////
	
	function search_id_card_listings()
    {       
		
		//echo $this->db->last_query();
		$this->_get_searched_id_card_listings_query($bundle_id);
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        //return $query->result();
		return $query->result_array();
    }

	
	function count_filtered_searched_listings($bundle_id){
		$this->_get_searched_id_card_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_searched_listings($bundle_id = NULL){        
		$this->_get_searched_id_card_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	private function _get_searched_id_card_listings_query(){			

	

		//just pass false param to not put fields in ``

		$this->db->select("ru.id, ru.regional_office_id, ru.assistant_director_office_id, ru.regional_office_code, ru.assistant_director_office_code, ru.generated_id_card_no, ru.form_bundle_id, ru.form_no, ru.original_user_photo, ru.thumb_user_photo, ru.original_signature, ru.thumb_signature, ru.complete_form_file, ru.en_artisian_first_name, ru.mobile_no, ru.en_district, ru.en_state, ru.created, ru.admin_verified_by,ru.reject_cause, CASE WHEN ru.is_verified=1 THEN 'Verified' WHEN ru.is_verified=2 THEN 'Rejected' WHEN ru.is_verified=0 THEN 'Un-verified' END AS card_status, ru.is_verified, ro.regional_title, ro.regional_code, ado.city, ado.city_code", false);

/*		$this->db->from('tt_registered_users ru')->join('tt_regional_office ro', 'ru.regional_office_id=ro.id', 'left')->join('tt_assistant_director_office ado', 'ru.assistant_director_office_id=ado.id', 'left');
*/
		$this->db->from('tt_registered_users ru')->join('tt_regional_office ro', 'ru.regional_office_id=ro.id', 'left')->join('tt_assistant_director_office ado', 'ru.assistant_director_office_id=ado.id', 'left');

		if(isset($_POST['generated_id_card_no']) and !empty($_POST['generated_id_card_no'])){
				$toteach=$_POST['generated_id_card_no'];
				$categ_array=explode('.',$toteach);
				foreach ($categ_array as $pr)
				{            
   					$aa.="'$pr'".',';
				}
				$vertAdv=substr($aa,0,-1);
		
				$search  = "ru.generated_id_card_no IN (".$vertAdv.")";
 				$this->db->where($search);
				//$this->db->where('ru.generated_id_card_no' ,($_POST['generated_id_card_no']));

		}
		
		
		
		if(isset($_POST['regional_office_id']) and !empty($_POST['regional_office_id'])){

			$this->db->where('ru.regional_office_id', $_POST['regional_office_id']);

		}

		if(isset($_POST['assistant_director_office_id']) and !empty($_POST['assistant_director_office_id'])){

			$this->db->where('ru.assistant_director_office_id', $_POST['assistant_director_office_id']);
		
		}
		
		if(isset($_POST['ed_working_area_id']) and !empty($_POST['ed_working_area_id'])){

			$this->db->where('ru.en_district', $_POST['ed_working_area_id']);

		}
		
		if(isset($_POST['letter_no']) and !empty($_POST['letter_no'])){
		
		
			 $letter_details = $this->db->query("SELECT * FROM tt_form_bundles WHERE 1=1 AND regional_office_id='".$_POST['regional_office_id']."' and 	assistant_director_office_id='".$_POST['assistant_director_office_id']."' and dch_letter_no='".$_POST['letter_no']."'")->row();
						
			$letterNo = $letter_details->id;
		
			$this->db->where('ru.form_bundle_id', $letterNo);

		}

		if(isset($_POST['en_name_of_craft']) and !empty($_POST['en_name_of_craft'])){

			$this->db->where('ru.en_name_of_craft', $_POST['en_name_of_craft']);

		}

		if(isset($_POST['en_gender']) and !empty($_POST['en_gender'])){

			$this->db->where('ru.en_gender', $_POST['en_gender']);

		}

		if(isset($_POST['en_aadhar_no']) and !empty($_POST['en_aadhar_no'])){

			$this->db->where('ru.en_aadhar_no', $_POST['en_aadhar_no']);

		}
		
		if(isset($_POST['voterCard']) and !empty($_POST['voterCard'])){

			$this->db->where('ru.voter_id_card_no', trim($_POST['voterCard']));

		}

		if(isset($_POST['mobile_no']) and !empty($_POST['mobile_no'])){

			$this->db->where('ru.mobile_no', $_POST['mobile_no']);

		}

		
		
		if(isset($_POST['en_cast']) and !empty($_POST['en_cast'])){
			$castName='';
			if($_POST['en_cast']=='Blank')
			{
				$castName='';
			}
			else
			{
				$castName=$_POST['en_cast'];
			}
			
			$this->db->where('ru.en_social_group_sc_st_obc', $castName);

		}
		
		if(isset($_POST['admin_user_id']) and !empty($_POST['admin_user_id'])){

			$this->db->where('ru.admin_verified_by', $_POST['admin_user_id']);

		}
		
		

		if(isset($_POST['is_verified']) and !empty($_POST['is_verified'])){

			if($_POST['is_verified']=='1')

			{

				$this->db->where('ru.is_verified', $_POST['is_verified']);

			}

			if($_POST['is_verified']=='2')

			{

				$this->db->where('ru.is_verified', $_POST['is_verified']);

			}

			if($_POST['is_verified']=='3')

			{

				$this->db->where('ru.is_verified', 0);

			}

		}

		else

		{

			$this->db->where('ru.is_verified', 1);

	  	}
		
		if(isset($_POST['en_state']) and !empty($_POST['en_state'])){

			$this->db->where('ru.en_state', $_POST['en_state']);

		}   

	   if($_POST['search']['value']){		
	   		
	   		$ltr_row = $this->db->query("SELECT id from tt_form_bundles WHERE 1=1 AND dch_letter_no='".$_POST['search']['value']."'")->row();	
			$this->db->where('(ru.form_bundle_id = "'.$ltr_row->id.'")', null, false);
	   }

	   

	   $column_order = array('ru.generated_id_card_no', 'ru.is_verified', 'ru.regional_office_code', 'ado.city','','','ru.created', ''); //set column field database for datatable orderable	   	

	    if(isset($_POST['order'])){

            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        }else{

			$this->db->order_by("ru.generated_id_card_no", "asc"); 

		}

	   	    

	}
	/////End search  section/////////

     function adm_detail_admin_users($admin_user_id=NULL)
    	{
		 	return $this->db->query("SELECT * FROM tt_admin_users where 1=1 and id='".$admin_user_id."'")->result_array();
	
		}
		function new_select_admin_users($admin_user_id=NULL,$start_date=NULL,$end_date=NULL)
    	{
		
			if($start_date!='' or $end_date!='')
			{
				$qrystr2 .= " and verified_date >= '".$start_date."' AND  verified_date <= '".$end_date."'";
			}
			if($admin_user_id!='')
			{
	 	 		return $this->db->query("SELECT count(admin_verified_by) as verifycount FROM tt_registered_users where 1=1 ".$qrystr2." and admin_verified_by='".$admin_user_id."' and is_verified=1")->result_array();
		 	}
    	}
		
		function new_select_admin_users_entry($admin_user_id=NULL,$start_date=NULL,$end_date=NULL)
    	{
			if($start_date!='' or $end_date!='')
			{
				$qrystr1 .= " and data_entry_submitted_date >= '".$start_date."' AND  data_entry_submitted_date <= '".$end_date."'";
			}
		
			if($admin_user_id!='')
			{
			 	 return $this->db->query("SELECT count(submitted_by_data_entry_id) as entrycount FROM tt_registered_users where 1=1 ".$qrystr1." and submitted_by_data_entry_id='".$admin_user_id."'")->result_array();
			}
    	}
		
		function new_select_admin_users_reject($admin_user_id=NULL,$start_date=NULL,$end_date=NULL)
    	{
			if($start_date!='' or $end_date!='')
			{
				$qrystr2 .= " and verified_date >= '".$start_date."' AND  verified_date <= '".$end_date."'";
			}
			if($admin_user_id!='')
			{
		 		return $this->db->query("SELECT count(admin_verified_by) as rejectcount FROM tt_registered_users where 1=1 ".$qrystr2." and admin_verified_by='".$admin_user_id."' and is_verified=2")->result_array();
			}
    	}

      //////////////////////////////Count Data entry and Verification for all Staff Start
	function dataentry_ppl_card_listings()
    {       
		$this->_get_dataentry_ppl_card_listings_query($bundle_id);
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
    	return $query->result_array();
    }

	function count_dataentry_searched_listings($bundle_id){
		$this->_get_dataentry_ppl_card_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function count_all_dataentry_ppl_searched_listings($bundle_id = NULL){        
		$this->_get_dataentry_ppl_card_listings_query($bundle_id);
		$query = $this->db->get();
		return $query->num_rows();		
    }
	
	private function _get_dataentry_ppl_card_listings_query()
	{
		if($_POST['is_verified']=='1')
		{
			$this->db->select("ru.id, ru.first_name, ru.last_name, ru.mobile_phone,ru.status,ru.city, ru.email, count(ro.admin_verified_by=ru.id) as verifycount",  false);
			$this->db->from('tt_admin_users ru')->join('tt_registered_users ro', 'ro.admin_verified_by=ru.id', 'left');
			$this->db->group_by('ro.admin_verified_by, ro.is_verified having ro.is_verified =1') ;
		
			if($_POST['start_dates'] and $_POST['end_dates'])
			{
				$this->db->where('ro.verified_date BETWEEN "'.date('Y-m-d', strtotime($_POST['start_dates'])). '" and "'.date('Y-m-d', strtotime($_POST['end_dates'])).'"');
			}
		}
		if($_POST['is_verified']=='3')
		{
			$this->db->select("ru.id, ru.first_name, ru.last_name, ru.mobile_phone,ru.status,ru.city, ru.email, count(ro.submitted_by_data_entry_id=ru.id) as entrycount",  false);
			$this->db->from('tt_admin_users ru')->join('tt_registered_users ro', 'ro.submitted_by_data_entry_id=ru.id', 'left');
			$this->db->group_by('ro.submitted_by_data_entry_id') ;
			if($_POST['start_dates'] and $_POST['end_dates'])
			{
				$this->db->where('ro.data_entry_submitted_date BETWEEN "'.date('Y-m-d', strtotime($_POST['start_dates'])). '" and "'.date('Y-m-d', strtotime($_POST['end_dates'])).'"');
			}
	
		}	
		if($_POST['is_verified']=='')
		{
			$this->db->select("ru.id, ru.first_name, ru.last_name, ru.mobile_phone,ru.status,ru.city, ru.email, count(ro.admin_verified_by=ru.id) as verifycount, count(ro.submitted_by_data_entry_id=ru.id) as entrycount",  false);
	
			$this->db->from('tt_admin_users ru')->join('tt_registered_users ro', 'ro.admin_verified_by=ru.id', 'left');
			$this->db->group_by('ro.admin_verified_by, ro.is_verified having ro.is_verified =1') ;
		}
		
    	if($_POST['search']['value'])
    	{		   
	 	 	$this->db->where('(ru.first_name LIKE "%'.$_POST['search']['value'].'%" OR ru.first_name LIKE "%'.$_POST['search']['value'].'%")', null, false);
    	}

    	if(isset($_POST['order']))
		{
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    	}
		else
		{
			$this->db->order_by("ru.id", "asc"); 
		}
	}
	//////////////////////////////Count Data entry and Verification for all Staff End

    function select_admin_users_log_info()
    {
		return $this->db->query("SELECT ru.*, ro.email, ro.first_name, ro.last_name, ro.mobile_phone, ro.status, ro.role_id, ro.role_id FROM tt_admin_users_login_logs ru LEFT JOIN  tt_admin_users ro ON ru.user_id=ro.id WHERE 1=1 and ro.status='active' and ro.role_id!=1 ORDER BY ru.last_login_date desc")->result_array();
    }
    
 	///////////////////////////////////////////REPORT SECTION END by ADITYA///////////
 	
 	function rejcardcount($letter_no=NULL)
    {
		return $this->db->query("SELECT COUNT(id) as total_rejected FROM tt_registered_users where 1=1 and is_verified=2 and form_bundle_id='".$letter_no."'")->result_array();
	}
	function veriycount($letter_no=NULL)
    {
		return $this->db->query("SELECT COUNT(id) as total_vfd FROM tt_registered_users where 1=1 and is_verified=1 and form_bundle_id='".$letter_no."'")->result_array();
	}
	function unverifycount($letter_no=NULL)
    {
		return $this->db->query("SELECT COUNT(id) as total_unverfd FROM tt_registered_users where 1=1 and is_verified=0 and form_bundle_id='".$letter_no."'")->result_array();
	}
	
	function restore_rejected_card()
    {
        $data['is_verified'] = 0;
		$data['admin_verified_by'] = 0;		
		$data['verified_date'] = NULL;
		$id = trim($this->input->post('id'));
        $this->db->where('form_bundle_id',$id);
		$this->db->where('is_verified',2);
        return $this->db->update('tt_registered_users',$data);
    }
    
    ////////////////bundle listing search by ADO
	
	private function _get_search_listings_ado(){				
		//just pass false param to not put fields in	
		
		$this->db->select("fb.*, ro.regional_title, ro.regional_code, ado.city", false);
		$this->db->from('tt_form_bundles fb')->join('tt_regional_office ro', 'fb.regional_office_id=ro.id', 'left')->join('tt_assistant_director_office ado', 'fb.assistant_director_office_id=ado.id', 'left');
			
		if(isset($_POST['regional_office_id']) and !empty($_POST['regional_office_id'])){
			$this->db->where('fb.regional_office_id', $_POST['regional_office_id']);
		}
		if(isset($_POST['assistant_director_office_id']) and !empty($_POST['assistant_director_office_id'])){
			$this->db->where('fb.assistant_director_office_id', $_POST['assistant_director_office_id']);
		}
			
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

function select_bundle_listings_ado(){
       /* return $this->db->query("SELECT fb.*, ro.regional_title, ro.regional_code, ado.city FROM tt_form_bundles fb LEFT JOIN tt_regional_office ro ON fb.regional_office_id=ro.id LEFT JOIN tt_assistant_director_office ado ON fb.assistant_director_office_id=ado.id ORDER BY fb.id DESC")->result_array();*/
	   //echo $this->db->last_query();
		$this->_get_search_listings_ado();
		if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        //return $query->result();
		return $query->result_array();
    }
	
	function count_filtered_bundle_ado(){
		$this->_get_search_listings_ado();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	 public function count_all_bundle_listings_ado(){        
		$this->_get_search_listings_ado();
		$query = $this->db->get();
		return $query->num_rows();		
    }
	///////////////end bundle listing by ADO
	
	//craft name
	function select_craft_name_list(){
        //return $this->db->get('tt_assistant_director_office')->result_array();
		return $this->db->query("SELECT * FROM  tt_craft_category WHERE 1=1 ORDER BY created asc")->result_array();
    }
    
    	///bank name start
	function select_bank_name()
    {
      // return $this->db->get('tt_bank_name')->result_array();
		return $this->db->query("SELECT * FROM  tt_bank_name WHERE 1=1 ORDER BY id asc")->result_array();
    }
	
	 function save_name_of_bank()
    {
        $data['bank_name'] = trim($this->input->post('bank_name'));
		$data['bank_code'] = trim($this->input->post('bank_code'));		
		$data['admin_created_by'] = $this->session->userdata('login_user_id');
		
        return $this->db->insert('tt_bank_name',$data);
    }
	function update_name_of_bank()
    {
        $data['bank_name'] = trim($this->input->post('bank_name'));
		$data['bank_code'] = trim($this->input->post('bank_code'));		
		//$data['admin_updated_by'] = $this->session->userdata('login_user_id');
		$id = trim($this->input->post('id'));
        $this->db->where('id',$id);
        return $this->db->update('tt_bank_name',$data);
    }
	//bank name end
	//edit district name
	function update_district_office()
    {
		$submit_btn_id = trim($this->input->post('submit_btn_id'));
		$data['title'] = trim($this->input->post('title'));
		$data['admin_updated_by'] = $this->session->userdata('login_user_id');
		$id = trim($this->input->post('id'));
        $this->db->where('id',$id);
        return $this->db->update('tt_ed_working_area',$data);
    }
    ////field boys
	function select_admin_field_boys()
    {
        return $this->db->query('SELECT ru.*, ro.regional_title,ro.regional_code, ado.city, ado.city_code FROM fieldboys_users ru LEFT JOIN tt_regional_office ro ON ru.regional_office_id=ro.id LEFT JOIN tt_assistant_director_office ado ON ru.assistant_director_office_id=ado.id  where 1=1 and ru.deleted=0 ORDER BY id desc')->result_array();
    }
    function find_field_boys_online()
    {
        return $this->db->query('SELECT * FROM field_boy_tracking where 1=1 and deleted=0')->result_array();
    }
    
    function is_aadhar_available($en_aadhar_no)  
    {  
           $this->db->where('en_aadhar_no', $en_aadhar_no);  
           $query = $this->db->get("tt_registered_users");  
           if($query->num_rows() > 0)  
           {  
                return true;  
           }  
           else  
           {  
                return false;  
           }  
    }  
}
