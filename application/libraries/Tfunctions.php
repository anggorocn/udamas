<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//=====================================================================================================================
//Misc public functions
//=====================================================================================================================
#
#
# Copyright (C) 2009 by Immanuel G. Souhoka (TriCoding Global Systems)

class Tfunctions
{

	var $query = "";
	
	public function user_access(){
		
		$ci	=& get_instance();
		$uri_1	= strtolower($ci->uri->segment(1));
		$uri_2	= ($ci->uri->segment(2) <> '') ? '/'.strtolower($ci->uri->segment(2)) : '';
		$uri_3	= ($ci->uri->segment(3) <> '') ? '/'.strtolower($ci->uri->segment(3)) : '';
		$uri_4	= ($ci->uri->segment(4) <> '') ? '/'.strtolower($ci->uri->segment(4)) : '';
		$uri_5	= ($ci->uri->segment(5) <> '') ? '/'.strtolower($ci->uri->segment(5)) : '';
		$uri_6	= ($ci->uri->segment(6) <> '') ? '/'.strtolower($ci->uri->segment(6)) : '';
		$uri_6	= ($ci->uri->segment(7) <> '') ? '/'.strtolower($ci->uri->segment(7)) : '';
		$uri_6	= ($ci->uri->segment(8) <> '') ? '/'.strtolower($ci->uri->segment(8)) : '';
		$uri_6	= ($ci->uri->segment(9) <> '') ? '/'.strtolower($ci->uri->segment(9)) : '';
		$uri_6	= ($ci->uri->segment(10) <> '') ? '/'.strtolower($ci->uri->segment(10)) : '';		
		$current_page	= $uri_1;
		
		for($i=2;$i<=10;$i++){
			if(!is_numeric($ci->uri->segment($i)))
			$current_page	.= ($ci->uri->segment($i) <> '') ? '/'.strtolower($ci->uri->segment($i)) : '';
		}
		
		if($ci->uri->segment(2) == ''){
			$current_page	.= '/index';
		}
		
		if($ci->session->userdata('s_id_user') <> ''){			
			$ci->db->select('distinct el.* ');
			$ci->db->from('ELEMENTS'.$ci->db->leyfi_db.' el');
			$ci->db->join('PERMISSIONS'.$ci->db->leyfi_db.' pr','pr.ELEMENT_ID = el.ELEMENT_ID');
			$ci->db->join('USERSINROLES'.$ci->db->leyfi_db.' ur','ur.ROLE_ID = pr.ROLE_ID');
			$ci->db->where('ur.USER_ID',$ci->session->userdata('s_id_user'),false);
			$resultElements = $ci->db->get();
			
			$user_access = array();
			foreach($resultElements->result() as $rows){
				array_push($user_access, $rows->ELEMENT_TYPE);
			}
			
			
			
			if (in_array($current_page, $user_access)) {
				return true;			
			}
			else{
				//~ return false;
				redirect('welcome/errorPage');
			}
		}else{
			redirect('login');
		}
		//~ return true;			
	}
	
	public function particularAccess($case){
		$ci	=& get_instance();
		$level		= $ci->session->userdata('level_user');
		$section	= $ci->session->userdata('user_section');
		
		$return 	= false;
		switch($case){
			case 'docApproval':
				if(($level == 1) || (($level == 4) && ($section == 1))){
					return true;
				}
			break;
			case 'docReports':
				if(($level == 1) || (($level == 4) && ($section == 2))){
					return true;
				}
			break;
		}	
		
		
		return $return;
	}
	
	/*
	 * validasi user untuk mengakses dokumen user lain
	 * */
	public function anotherDocAccess(){
		$ci	=& get_instance();
		$ci->load->model("muser");
		
		$userLevel = $ci->session->userdata("level_user");
		$userId = $ci->session->userdata("s_id_user");
		$uri_1	= strtolower($ci->uri->segment(1));
		
		if($ci->uri->segment(2) <> ''){
			$uri2 = strtolower($ci->uri->segment(2));
			
			switch($uri2){
				case "view": 
				case "views": 
				case "entry":
				case "generate_pdf":
					if(($uri2 == "entry")){
						$doc_id = ($ci->uri->segment(4) <> '') ? '/'.strtolower($ci->uri->segment(4)) : '';
					}else{
						$doc_id	= strtolower($ci->uri->segment(3));
					}
				
					if($doc_id <> ''){
						return $ci->muser->validUserAccess($userLevel, $userId, $doc_id, $uri_1);
					}
				break;
			}
			
		}
		
		return true;
	}
	
	public function StrToDouble($number, $thousand = '.'){         
		if($thousand == '.')
		{
			$aa = preg_replace("/[.]/","",$number);
			$return = preg_replace("/[,]/",".",$aa);
			
		}
		else{
			$aa = preg_replace("/[,]/","",$number);
			$return = preg_replace("/[.]/",",",$aa);
			
		}
		return $return;     
	} 
	
	public function createPaging($bUrl, $totalData, $limit = 20){
		$ci	=& get_instance();
		
		$config['base_url'] 	= $bUrl;
		$config['total_rows'] 	= $totalData;
		$config['per_page'] 	= $limit;
		$config['num_links'] 	= 1;
		$config['uri_segment'] 	= 4;       
		$config['use_page_numbers']  = TRUE;
		$config['first_link'] 	= 'Awal';
		$config['last_link'] 	= 'Akhir';
		$config['next_page'] 	= '&laquo;';
		$config['prev_page'] 	= '&raquo;';
		
		
		$config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
		$config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
		 
		$config['cur_tag_open'] = "<li><span><b>";
		$config['cur_tag_close'] = "</b></span></li>";
		
		
		
		//inisialisasi config
		$ci->pagination->initialize($config);
		return $ci->pagination->create_links();
	}
	
	public function sorting($sort){
		$CI =& get_instance();
		$return_class = '';
		if(($CI->session->userdata('s_order_by') == $sort) && ($CI->session->userdata('s_order_direction') == 'ASC'))
		{
			$return_class = 'sorting_desc';
		}
		elseif(($CI->session->userdata('s_order_by') == $sort) && ($CI->session->userdata('s_order_direction') == 'DESC'))
		{
			$return_class = 'sorting_asc';
		}
		
		return $return_class;
	}
	
	public function massegeTime($start , $end){
		$start_date = new DateTime($start);
		$since_start = $start_date->diff(new DateTime($end));
		
		$tahun	= $since_start->y;
		$bulan	= $since_start->m;
		$hari	= $since_start->d;
		$jam	= $since_start->h;
		$menit	= $since_start->i;
		$detik	= $since_start->s;
		
		
		$return	= array();
		if($tahun > 0){
			$return = array('type' => 'Tahun', 'value' => $tahun);
		}
		elseif($bulan > 0){
			$return = array('type' => 'Bulan', 'value' => $bulan);
		}
		elseif($hari > 0){
			$return = array('type' => 'Hari', 'value' => $hari);
		}
		elseif($jam > 0){
			$return = array('type' => 'Jam', 'value' => $jam);
		}
		elseif($menit > 0){
			$return = array('type' => 'Menit', 'value' => $menit);
		}
		elseif($detik > 0){
			$return = array('type' => 'Detik', 'value' => $detik);
		}
					
		return $return;
	}
	
	public function ambilStatus($status){
		$return = "";
		
		$CI =& get_instance();
		switch($CI->session->userdata('level_user')){
			case 4:
				switch($status){
					case 2: $return = "Baru"; break;
					case 7: $return = "Re-Submit"; break;
				}
			break;
			
			case 3:
			case 2:
			switch($status){
					case 4: $return = "Disetujui"; break;
					case 3: $return = "Pending"; break;					
				}
			break;
			
		}
		
		return $return;
	}
	
	public function check_module($module_name)
	{
		$CI =& get_instance();
		if ($module_name <> $CI->session->userdata('s_module'))
		{
			$CI->session->set_userdata('s_keyword','');
			$CI->session->set_userdata('s_sort_by','');
			$CI->session->set_userdata('s_sort_alt','');
			$CI->session->set_userdata('s_sort_direction','ASC');
			$CI->session->set_userdata('s_module',$module_name);
		}
	}
	
	public function get_object_value($object, $field, $type = '')
	{
		$CI =& get_instance();
		
		$post_data	= $CI->session->flashdata('post_data');

		if (isset($post_data['f_'.$field]))
		{
			if ($type == 'date')
			{
				return $this->convert_date($post_data['f_'.$field],1);
			}
			else
			{
				if ($type == 'datetime')
				{
					return $this->convert_date($post_data['f_'.$field],1).' '.$post_data['f_hour_'.$field].':'.$post_data['f_minute_'.$field];
				}
				else
				{
					return $post_data['f_'.$field];
				}
			}
		} 
		else
		{
			$rtn = '';
			if(isset($object->$field)){
				if (!empty($object))
				{
					$rtn = $object->$field;
				}
			}
			return $rtn;			
		}
	}
	
	public function generate_form($object, $elements){
		$CI =& get_instance();
		
		$form 	= array();
		$class	= 'input_text';
		foreach($elements as $id => $properties)
		{
			$value	= $this->get_object_value($object,$id, $properties['type']);
			
				if ($CI->session->flashdata($id) <> '')
				{
					$class = 'input_error';
				}
				else
				{
					$class = 'input_text';
				}
				
				switch($properties['type'])
				{
					case 'hidden' 	:
						$form_element	= form_hidden('f_'.$id,$value);
						break;
					
					case 'input'	:
						$arr_form		= array(
											"name"	=> 'f_'.$id,
											"id"	=> 'f_'.$id,
											"value"	=> $value,
											"title"	=> isset($properties['title']) ? $properties['title']:'',
											"size"	=> isset($properties['size']) ? $properties['size']:10,
											"class"	=> $class.' '.((isset($properties['class'])) ? $properties['class']:'')
											);
											
						if (isset($properties['readonly']))
						{
							$arr_form['readonly']	= 'readonly';
						}
						if (isset($properties['disabled']))
						{
							$arr_form['disabled']	= '';
						}
						
						$form_element	= form_input($arr_form);
						break;
						
					case 'password'	:
						$arr_form		= array(
											"name"	=> 'f_'.$id,
											"id"	=> 'f_'.$id,
											"value"	=> $value,
											"title"	=> isset($properties['title']) ? $properties['title']:'',
											"size"	=> isset($properties['size']) ? $properties['size']:10,
											"class"	=> $class);
											
						if (isset($properties['readonly']))
						{
							$arr_form['readonly']	= 'readonly';
						}
						$form_element	= form_password($arr_form);
						break;
						
					case "date" :
						if (($value == "") && (!isset($properties['default_value'])))
						{
							$value		= date("d-m-Y");
						}elseif(($value == "") && (isset($properties['default_value'])))
						{
							$value		= $properties['default_value'];
						}
						else
						{
							$value		= $this->convert_date($value,3 );
						}
						
						$arr_form		= array(
											"name"	=> 'f_'.$id,
											"id"	=> 'f_'.$id,
											"value"	=> $value,
											"title"	=> isset($properties['title']) ? $properties['title']:'',
											"size"	=> isset($properties['size']) ? $properties['size']:10,
											"class"	=> "input_text input_date");
						$form_element	= form_input($arr_form);
															
															
						break;
						
					case "datetime" :
						if ($value == "")
						{
							$value_date		= date("d/m/Y");
							$value_hour		= '07';
							$value_minute	= '00';
						}
						else
						{
							$values			= explode(' ',$value);
							$value_date		= $this->convert_date($values[0],2);
							$values_times	= explode(':',$values[1]);
							$value_hour		= $values_times[0];
							$value_minute	= $values_times[1];
						}
						
						$arr_form		= array(
											"name"	=> 'f_'.$id,
											"id"	=> 'f_'.$id,
											"value"	=> $value_date,
											"title"	=> isset($properties['title']) ? $properties['title']:'',
											"size"	=> isset($properties['size']) ? $properties['size']:10,
											"class"	=> "input_text input_date");
						$form_element	= form_input($arr_form).' '.form_dropdown_time($id,$value_hour,$value_minute);
															
															
						break;
						
					case "number" :
						if ($value == "")
						{
							$value		= '0';
						}
						
						$arr_form		= array(
											"name"	=> 'f_'.$id,
											"id"	=> 'f_'.$id,
											"value"	=> $value,
											"title"	=> isset($properties['title']) ? $properties['title']:'',
											"size"	=> isset($properties['size']) ? $properties['size']:10,
											"class"	=> "input_number");
											
						if (isset($properties['readonly']))
						{
							$arr_form['readonly']	= 'readonly';
						}
						
						if (isset($properties['disabled']))
						{
							$arr_form['disabled']	= '';
						}
						
						$form_element	= form_input($arr_form);
															
															
						break;
						
						
					case "file" :
						$arr_form		= array(
											"name"	=> 'f_'.$id,
											"id"	=> 'f_'.$id,
											"value"	=> '',
											"title"	=> isset($properties['title']) ? $properties['title']:'',
											"size"	=> isset($properties['size']) ? $properties['size']:10,
											"class"	=> "input_number");
											
						if (isset($properties['readonly']))
						{
							$arr_form['readonly']	= 'readonly';
						}
						
						$form_element	= form_upload($arr_form);
															
															
						break;
						
						
					case "textarea" :
						$arr_form		= array(
											"name"	=> 'f_'.$id,
											"id"	=> 'f_'.$id,
											"value"	=> $value,
											"rows"	=> isset($properties['rows']) ? $properties['rows']:10,
											"cols"	=> isset($properties['cols']) ? $properties['cols']:10,
											"class"	=> $class);
						
						
						if (isset($properties['readonly']))
						{
							$arr_form['readonly']	= 'readonly';
						}
						
							$form_element	= form_textarea($arr_form);
						break;					
						
					case "dropdown" :
						$CI 			=& get_instance();
						
						$form_element	= $CI->project_functions->create_dropdown($properties['dtype'],
																				  'f_'.$id,
																				  isset($properties['dvalue']) ? $properties['dvalue']:'',
																				  isset($properties['dtext']) ? $properties['dtext']:'',
																				  $value);
						
						break;
						
					
					case "checkbox"	:
						$arr_form		= array(
											"name"	=> 'f_'.$id,
											"id"	=> 'f_'.$id,
											"value"	=> $properties['value'],
											"checked"=>$value,
											"class"	=> $class);
						$form_element	= form_checkbox($arr_form);
						break;
					
						
				}
	
	
				//$translation	= new Translation();
				//$label			= $translation->translate($object->table, $id);
				
	
				if (isset($properties['label']))
				{
					$label 		= isset($properties['label']) ? $properties['label']:'';
				}else
				{
					//~ $label			= $object->localize_label($id);
					$label			= '';
				}
				
				
				$form['v_'.$id]	= $value;
				$form['f_'.$id]	= $form_element;
				
				$form['l_'.$id]	= form_label($label);
				
				if ($properties['type'] != 'hidden')
				{
					$form_label		= form_label($label,'f_'.$id);
				}
				else
				{
					$form_label		= '';
				}
				
				$form['elements'][] = array('label'	=> $form_label,
										  'form'	=> $form_element,
										  'row'		=> isset($properties['label']) ? 'tr_'.$id : 'tr_'); 
		}
		
		return $form;
	}
	
	
	//Generate form information (created by & last modifier)
	//created by Immanuel G. Souhoka on 12.11.2012 04:46
	public function generate_form_info($object, $id)
	{
		$log	= new Log();
		$creator		= $log->get_creator($object,$id);
		$modifier		= $log->get_last_modifier($object,$id);
		
		$info			= '';
		if($id != '0')
		{
			$info		.= '<div class="info">';
			$info		.= 'Created By '.$creator['created_by'].' On '.$this->convert_date($creator['created_date'],10).'&nbsp;&nbsp;&nbsp;Last Updated By '.$modifier['modified_by'].' On '.$this->convert_date($modifier['modified_date'],10);	
			$info		.= '</div>';
		}
		
		return $info;
	}
	
	//Generate form error validation information
	//created by Immanuel G. Souhoka on 12.11.2012 04:46
	public function generate_form_error()
	{
		$CI =& get_instance();
		
		$error			= '';
		if($CI->session->flashdata('string') != '')
		{
			$error		.= '<div class="error_post">';
			$error		.= $CI->session->flashdata('string');
			$error		.= '</div>';
		}
		
		return $error;
	
	}

	public function set_error($object_errors)
	{
		$CI =& get_instance();
		
		foreach($object_errors as $field_error => $error_message)
		{
			$CI->session->set_flashdata($field_error, $error_message);
		}
	}
	
	
	
	//Check if the value is unique or not
	//created by Immanuel G. Souhoka on 10.08.2009 09:19
	public function is_unique($new_value,$table,$field)
	{
		$CI =& get_instance();
		$CI->load->database();

		$CI->db->where($field,$new_value);
		$query	= $CI->db->get($table);
		
		$result = true;
		
		if ($query->num_rows() > 0)
		{
			$result	= false;
		}
		else
		{
			$result = true;
		}
		
		return $result;
	}
	
	//check if the id already exist in related tables
	//created by Immanuel G. Souhoka on 07.11.2012 16:30
	public function is_exist($object, $exclude = array())
	{
		$count_exist	= 0;
		
		foreach($object->has_many as $related_table => $properties)
		{
			$found		= FALSE;
			$found		= array_search($related_table,$exclude);
			
			if ($found === FALSE)
			{
				$count_exist += $object->$related_table->count();
			}
		}
		
		if ($count_exist > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	
	//Convert Date 
	//created by Immanuel G. Souhoka 01.07.2009 19:39
	public function convert_date($date = '',$convert_type)
	{
		if ((!empty($date)) || $date <> '')
		{
			
			switch($convert_type)
			{
				//from dd/mm/yyyy  to  yyyy-mm-dd
				case 1 :
					$dates 	= explode("/",$date);
					$date   = $dates[2]."-".$dates[1]."-".$dates[0];
					break;
				
				//from yyyy-mm-dd  to  dd/mm/yyyy
				case 2 :
					$dates 	= explode("-",$date);
					$date   = $dates[2]."/".$dates[1]."/".$dates[0];
					break;

				//from dd-mm-yyyy  to  yyyy-mm-dd
				case 3 :
					$dates 	= explode("-",$date);
					$date   = $dates[2]."-".$dates[1]."-".$dates[0];
					break;

				//from dd/mm/yyyy  to  dd MMMM YYYY
				case 4 :
					$dates 	= explode("/",$date);
					
					switch ($dates[1])
					{
						case 1 : $month	= "Januari"; break;
						case 2 : $month	= "Februari"; break;
						case 3 : $month	= "Maret"; break;
						case 4 : $month	= "April"; break;
						case 5 : $month	= "Mei"; break;
						case 6 : $month	= "Juni"; break;
						case 7 : $month	= "Juli"; break;
						case 8 : $month	= "Agustus"; break;
						case 9 : $month	= "September"; break;
						case 10: $month	= "Oktober"; break;
						case 11: $month	= "Nopember"; break;
						case 12: $month	= "Desember"; break;
					}
					
					$date   = $dates[0]." ".$month." ".$dates[2];
					break;
				
				
				case 5 :
					$dates 	= explode("-",$date);
					$date	= mktime(0,0,0,$dates[1],$dates[2],$dates[0]);
					break;
					
				//from yyyy-mm-dd  to  dd MMMM YYYY
				case 6 :
					$dates 	= explode("-",$date);
					
					switch ($dates[1])
					{
						case 1 : $month	= "Januari"; break;
						case 2 : $month	= "Februari"; break;
						case 3 : $month	= "Maret"; break;
						case 4 : $month	= "April"; break;
						case 5 : $month	= "Mei"; break;
						case 6 : $month	= "Juni"; break;
						case 7 : $month	= "Juli"; break;
						case 8 : $month	= "Agustus"; break;
						case 9 : $month	= "September"; break;
						case 10: $month	= "Oktober"; break;
						case 11: $month	= "Nopember"; break;
						case 12: $month	= "Desember"; break;
					}
					
					$date   = $dates[2]." ".$month." ".$dates[0];
					break;
				
				//from Sunday...Saturday to Minggu...Sabtu
				case 7 :
					switch ($date)
					{
						case "Sunday" 	: $date = "Minggu"; break;
						case "Monday" 	: $date = "Senin"; break;
						case "Tuesday"	: $date = "Selasa"; break;
						case "Wednesday": $date = "Rabu"; break;
						case "Thursday" : $date = "Kamis"; break;
						case "Friday" 	: $date = "Jumat"; break;
						case "Saturday" : $date = "Sabtu"; break;
					}
					break;
					
				//from dd-mm  to  dd MMMM
				case 8 :
					$dates 	= explode("-",$date);
					switch ($dates[1])
					{
						case 1 : $month	= "Januari"; break;
						case 2 : $month	= "Februari"; break;
						case 3 : $month	= "Maret"; break;
						case 4 : $month	= "April"; break;
						case 5 : $month	= "Mei"; break;
						case 6 : $month	= "Juni"; break;
						case 7 : $month	= "Juli"; break;
						case 8 : $month	= "Agustus"; break;
						case 9 : $month	= "September"; break;
						case 10: $month	= "Oktober"; break;
						case 11: $month	= "Nopember"; break;
						case 12: $month	= "Desember"; break;
					}

					$date   = $dates[0]." ".$month;
					break;
					
				//from dd-mm-yyyy  to  MMMM YYYY, dd
				case 9 :
					$dates = explode("-",$date);
					switch ($dates[1])
					{
						case 1 : $month	= "January"; break;
						case 2 : $month	= "February"; break;
						case 3 : $month	= "March"; break;
						case 4 : $month	= "April"; break;
						case 5 : $month	= "May"; break;
						case 6 : $month	= "June"; break;
						case 7 : $month	= "July"; break;
						case 8 : $month	= "August"; break;
						case 9 : $month	= "September"; break;
						case 10: $month	= "October"; break;
						case 11: $month	= "November"; break;
						case 12: $month	= "December"; break;
					}
					$date   = $month." ".$dates[2].", ".$dates[0];
					break;
					
				//from yyyy-mm-dd hh:mm:ss  to  dd/mm/yyyy hh:mm:ss
				case 10:
					$timestamp	= explode(" ",$date);
					$dates 	= explode("-",$timestamp[0]);
					$date   = $dates[2]."/".$dates[1]."/".$dates[0]." ".$timestamp[1];
					break;
					
				//from yyyy-mm-dd  to  dd-mm-yyyy
				case 11 :
					$dates 	= explode("-",$date);
					$date   = $dates[2]."-".$dates[1]."-".$dates[0];
					break;	
				
				//from dd-mm-yyyy to dd-MM-YYYY
				case 12 :
					$dates 	= explode("-",$date);
					
					switch ($dates[1])
					{
						case 1 : $month	= "Jan"; break;
						case 2 : $month	= "Feb"; break;
						case 3 : $month	= "Mar"; break;
						case 4 : $month	= "Apr"; break;
						case 5 : $month	= "May"; break;
						case 6 : $month	= "Jun"; break;
						case 7 : $month	= "Jul"; break;
						case 8 : $month	= "Aug"; break;
						case 9 : $month	= "Sep"; break;
						case 10: $month	= "Oct"; break;
						case 11: $month	= "Nov"; break;
						case 12: $month	= "Dec"; break;
					}
					
					$date   = $dates[0]."-".$month."-".$dates[2];
					break;	
					
				//from yyyy-MM-dd to dd-mm-yyyy
				case 13 :
					$dates 	= explode("-",$date);
					
					switch ($dates[1])
					{
						case "JAN" : $month	= "01"; break;
						case "FEB" : $month	= "02"; break;
						case "MAR" : $month	= "03"; break;
						case "APR" : $month	= "04"; break;
						case "MAY" : $month	= "05"; break;
						case "JUN" : $month	= "06"; break;
						case "JUL" : $month	= "07"; break;
						case "AUG" : $month	= "08"; break;
						case "SEP" : $month	= "09"; break;
						case "OCT" : $month	= "10"; break;
						case "NOV" : $month	= "11"; break;
						case "DEC" : $month	= "12"; break;
					}
					
					$date   = $dates[0]."-".$month."-".$dates[2];
					break;	
					
			}

		}
		else
		{
			$date = '';
		}
		return($date);
	}
	
	public function getdate_by_day($day, $number_of_week)
	{
		return date('Y-m-d',strtotime("$day +$number_of_week week"));
	}
	
	//Leap Year public function
	public function is_leap_year($Thn)
	{
		$LeapY = $Thn % 4;

		if ($LeapY == 0)
		{
			return(true);
		}
		else
		{
			return(false);
		}
	}
	

	//Find Last Date of the given month and year
	public function get_last_date_of_month($month,$year)
	{
		switch ($month)
		{
			case "1":
			case "3":
			case "5":
			case "7":
			case "8" :
			case "10":
			case "12" :
				$date = 31;
				break;

			case "2" :
				if ($this->is_leap_year($year))
				{
					$date = 29;
				}
				else
				{
					$date = 28;
				}
				break;

			case "4" :
			case "6" :
			case "9" :
			case "11" :
				$date = 30;
				break;
		}

		return($date);
	}


	public function set_additional_zero($number,$length)
	{
		$string_length		= strlen($number);
		$additional_length	= $length - $string_length;
		
		$new_number			= $number;
		for($i = 0; $i < $additional_length; $i++)
		{
			$new_number		= "0".$new_number;
		}
		return $new_number;
	
	}
	
		
	//	Created By: 
	//	 Diego Szwebel - popele@gmail.com
	//	 Montevideo - Uruguay

	// It generates a random number of $digits digits. The second and third parameter is optional. 
	// The second one is used when you want that the code be a string of $digits digits. 
	// For that you add zeros in the away numbers. The third parameter says if the minimum number to use the random public function begins in 1 or 0.
	public function create_random_number($digits_quantity, $string = false, $zero = 1)
	{
		$random_number = 0;
		$digits = 0;
	
		while($digits < $digits_quantity)
		{
			$rand_max .= "9";
			$digits++;
		}
		
		mt_srand((double) microtime() * 1000000); 
		$random_number = mt_rand($zero, intval($rand_max));
	
		if($string)
		{
			if(strlen(strval($random_number)) < $digits_quantity)
			{
				$zeros_quantity = $digits_quantity - strlen(strval($random_number));
				$digits = 0;
				while($digits < $zeros_quantity)
				{
					$str_zeros .= "0";
					$digits++;
				}
				$random_number = $str_zeros . $random_number;
			}
		}	
		return $random_number;
	}	
	
	public function generate_password($name, $date)
	{
		$name		= trim($name);
		$name		= str_replace(' ','',$name);
		$name		= strtolower(str_replace('.','',$name));
		
		$dates 		= explode("-",$date);
		$day		= $dates[2];
		$month		= $dates[1];
		$year		= $dates[0];
		
		$pass 		= $name." ".$day.$month.$year;

		$char_length= 5;
		$num_length	= 2;
		
		$pass		= '';
		
		for ($x = 0;$x < $char_length;$x++)
		{
			$len	= strlen($name)-1;
			$rnd	= mt_rand(0,$len);
			$pass .= $name[$rnd];
		}
		
		for ($y = 0;$y < $num_length;$y++)
		{
			$rnd	= mt_rand(0,2);
			$pass .= substr($dates[$rnd],-2);
		}
		
		
		return $pass;
	
	}
	
	public function string2array($strings, $separator)
	{
		$aString	= explode($separator,$strings);
		
		return $aString;
	}

		
	public function strtoint($strings)
	{
		$number 	= str_replace('.','',$strings);
		$number 	= str_replace(',','.',$number);
		
		return $number;
	}
	
	
	//Adding Timestamp 
	//format $current_timestamp --> 'yyyy-mm-dd hh:mm:ss'
	//$type :
	//h : adding hour
	//m : adding minute
	//s : adding second
	//D : adding date
	//M : adding month
	//Y : adding year
	//created by Immanuel G. Souhoka 16.01.2010 16:57
	function add_timestamp($current_timestamp,$interval,$type,$using_time = TRUE)
	{
		$timestamp	= explode(" ",$current_timestamp);

		$dates		= explode("-",$timestamp[0]);
		$date		= $dates[2];
		$month		= $dates[1];
		$year		= $dates[0];

		if ($using_time == TRUE)
		{
			$times		= explode(":",$timestamp[1]);
			$hour		= $times[0];
			$minute		= $times[1];
			$second		= $times[2];
		}
		else
		{
			$hour		= 0;
			$minute		= 0;
			$second		= 0;
		
		}
		
		switch($type)
		{
			case "h" :
				$hour			= $hour + $interval;
				break;
				
			case "m" :
				$minute			= $minute + $interval;
				break;
				
			case "s" :
				$second			= $second + $interval;
				break;
				
			case "D" :
				$date			= $date + $interval;
				break;
				
			case "M" :
				$month			= $month + $interval;
				break;
				
			case "Y" :
				$year			= $year + $interval;
				break;
		}
		
		$unix_time	= mktime($hour, $minute, $second, $month, $date, $year);
		
		if ($using_time == TRUE)
		{
			$result		= date("Y-m-d H:i:s", $unix_time);
		}
		else
		{
			$result		= date("Y-m-d", $unix_time);
		}
		
		return $result;
	}
	
	public function stripHTMLtags($str)
	{
	    $t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
	    $t = htmlentities($t, ENT_QUOTES, "UTF-8");
	    return $t;
	}

}

?>
