<?php
class Extract extends Controller{

	function extract(){
		parent::Controller();
		$this->load->helper('security');
	}

	function index(){		
		$file_list = array(
			0 => 'dentists-1-100',
			1 => 'dentists-101-200',
			2 => 'dentists-201-300',
			3 => 'dentists-401-500',
			4 => 'dentists-501-600',
			5 => 'dentists-601-700',
			6 => 'dentists-701-800',
			7 => 'dentists-801-900',
			8 => 'dentists-901-1020',
			9 => 'dentists-1101-1200'
		);
		foreach($file_list AS $list){
			echo 'processing '.$list.'<br/>';
			$this->file($list);
		}
	}
	function file($filename){
		error_reporting(E_ALL ^ E_NOTICE);
		$read_file = $filename.'.xls';
		$pathToFile = 'user_assets/dentist_data/'.$read_file;
		$params = array('file' => $pathToFile, 'store_extended_info' => true,'outputEncoding' => '');

		$this->load->library('Spreadsheet_Excel_Reader', $params);
		$xlsFile = $this->spreadsheet_excel_reader->dumptoarray();
	
		foreach($xlsFile AS $field){
			$data = array(
				'company_name' => $field[2],
				'name' => $field[3],
				'bio' => $field[4],
				'address' => $field[5],
				'city' => $field[6],
				'state' => $field[7],
				'zip' => $field[8],
				'phone' => $field[9],
				'email' => $field[10],
				'website' => $field[11],
				'monday' => $field[12],
				'tuesday' => $field[13],
				'wednesday' => $field[14],
				'thursday' => $field[15],
				'friday' => $field[16],
				'saturday' => $field[17],
				'sunday' => $field[18],
				'qualifications' => $field[19],
				'certifications' => $field[20],
				'specialties' => $field[21],
				'promotion_titles' => $field[22],
				'promotion_descriptions' => $field[23],
				'promo_codes' => $field[24],
				'dentist_image' => $field[25],
				'dentist_description_image' => $field[26],
				'other_images' => $field[27],
				'before_and_after' => $field[28],
				'source_file' => $read_file
			);
			$this->db->insert('data_dentists_raw',$data);
		}
		echo count($xlsFile).' inserted from '.$read_file.'<br/><br/>';
	}
	function clean_state(){ //mark clean states and assing proper state_abbr
		$res = $this->db->get('data_dentists_raw_distinct');
		$dets = $res->result_array();
		foreach($dets AS $det){
			$state = $det['state'];
			if(strlen($state) > 2){
				$where = array('state_long' => $state);
				$this->db->select('id,state_abbr');
				$state_res = $this->db->get_where('data_states',$where);
				$state_res = $state_res->row_array();
				if($state_res){
				//	echo $state_res['state_abbr'].'<br/>';
					//update here;
					$up_data = array(
						'state' => $state_res['state_abbr'],
						'valid_state' => 1
					);
					$this->db->update('data_dentists_raw_distinct', $up_data, array('id' => $det['id']));
					echo 'Updated <br/>'.$state_res['state_abbr'];
				}else{
					echo 'INVALID: '.$state.'<br/>';
				}
			}else{
				$where = array('state_abbr' => $state);
				$this->db->select('id,state_abbr');
				$state_res = $this->db->get_where('data_states',$where);
				$state_res = $state_res->row_array();
				if($state_res){
					//echo $state_res['state_abbr'].'<br/>';
					$up_data = array(
						'state' => $state_res['state_abbr'],
						'valid_state' => 1
					);
					$this->db->update('data_dentists_raw_distinct', $up_data, array('id' => $det['id']));
					echo 'Updated '.$state_res['state_abbr'].' <br/>';
				}else{
					echo 'INVALID STATE ABBR <br/>';
				}
			}
		}
	}
	function clean_zip_assign_city(){ //mark clean zip codes and assign clean city name
		$res = $this->db->get('data_dentists_raw_distinct');
		$dets = $res->result_array();
		foreach($dets AS $det){
			$zip = $det['zip'];
			$zip = str_replace('?','',$zip);
			$zip = str_replace('/','',$zip);
			$zip = explode('-',$zip);
			$zip = $zip[0];
			if(is_numeric($zip)){	
				$where = array('zip_code' => $zip);
				$this->db->select('city_name');
				$zip_res = $this->db->get_where('data_locations',$where);
				$zip_res = $zip_res->row_array();
				if($zip_res){
					//echo $zip. ':'. $zip_res['city_name'].'('.$det['city'].')'.'<br>';
					$up_data = array(
						'city' => ucwords(strtolower($zip_res['city_name'])),
						'valid_zip' => 1,
						'valid_city' => 1,
						'zip' => $zip
					);
				//	$this->db->update('data_dentists_raw_distinct', $up_data, array('id' => $det['id']));
				//	echo '<b>UPDATED '.$zip.' ('.$det['zip'].') '.$zip_res['city_name'].' ('.$det['city'].')</b></br>';
				}else{
					echo 'DB INVALID: '.$zip.' '.$det['city'].'<br/> ';
				}
			}else{
				echo 'INVALID: '.$zip.'<br/> '.$zip_res['city_name'].' '.$det['city'];
			}
		}
	}
	function clean_city(){ //mark clean cities
		$res = $this->db->get('data_dentists_raw_distinct');
		$dets = $res->result_array();
		foreach($dets AS $det){
			$city = $det['city'];
			$where = array('city_name' => $city);
			$this->db->select('city_name');
			$city_res = $this->db->get_where('data_locations',$where);
			$city_res = $city_res->row_array();
			if($city_res){
				//echo 'VALID '.$city.'('.$city_res['city_name'].')<br/>';
				$up_data = array(
					'city' => ucwords($city),
					'valid_city' => 1
				);
				$this->db->update('data_dentists_raw_distinct', $up_data, array('id' => $det['id']));
				echo '<b>UPDATED '.$city.'</b></br>';
			}else{
				$up_data = array(
					'city' => ucwords($city),
					'valid_city' => 0
				);
				$this->db->update('data_dentists_raw_distinct', $up_data, array('id' => $det['id']));
				echo 'INVALID '.$city.'<br/>';
			}
		}
	}
	function clean_assign_emails(){
		$this->load->helper('email');
		$res = $this->db->get('data_dentists_raw_distinct');
		$dets = $res->result_array();
		foreach($dets AS $det){
			if(valid_email($det['email'])){
				$up_data = array(
					'valid_email' => 1,
					'login_email' => $det['email']
				);
				$this->db->update('data_dentists_raw_distinct', $up_data, array('id' => $det['id']));
				echo 'VALID  : '.$det['email'].'<br/>';
			}else{
				echo '<b>INVALID : '.$det['email'].' '.'temp_'.$det['id'].'@dentistsearchusa.com'.'</b><br/>';
				$up_data = array(
					'valid_email' => 0,
					'login_email' => 'temp_'.$det['id'].'@dentistsearchusa.com'
				);
				$this->db->update('data_dentists_raw_distinct', $up_data, array('id' => $det['id']));
			}
		}
	}
	function clean_website_address(){
		$res = $this->db->get('data_dentists_raw_distinct');
		$dets = $res->result_array();
		foreach($dets AS $det){
			if($det['website']){
				$url = str_replace('http://','',$det['website']);
				$url = str_replace('?','',$url);
				$url = explode('/',$url);
				echo $url[0].'<br/>';
				
				$up_data = array(
					'valid_website' => 1,
					'website' => $url[0]
				);
				$this->db->update('data_dentists_raw_distinct', $up_data, array('id' => $det['id']));
			}
		}
	}
	function clean_name(){
		$res = $this->db->get('data_dentists_raw_distinct');
		$dets = $res->result_array();
		foreach($dets AS $det){
		//	$name = $det['name'];
			$name = str_replace('Dr. ','',$det['name']);
			$name = str_replace('Dr ','',$name);
			$name = str_replace('Dr.','',$name);
		//	$name = str_replace('Dr','',$name);
		//	$name = preg_replace('/[A-Z]\./','',$name);
		//	echo $name.'<br/>';
			preg_match("/^(?<title>.*\.\s)*(?<firstname>([A-Z][a-z]+\s*)+)(\s)(?<middleinitial>([A-Z]\.?\s)*)(?<lastname>[A-Z][a-zA-Z-']+)(?<suffix>.*)$/",$name,$result);
			if(!empty($result)){
				$nominal = @substr($result['suffix'],2);
				if(!$nominal){
					$nominal = '';
				}
				echo $det['id'].' <b>firstname</b>: '.@$result['firstname'].' <b>lastname</b>: '.@$result['lastname'].' <b>nominal</b>: '.$nominal.' <b>MI:</b>'.$result['middleinitial'].'('.$name.')<br/>';
				$up_data = array(
					'valid_name' => 1,
					'first_name' => @$result['firstname'],
					'last_name' => @$result['lastname'],
					'middle_initial' => @$result['middleinitial'],
					'post_nominal' => $nominal
				);
			}else{
				$thename = explode(', ',$name);
				$name = explode(' ',$thename[0]);
				if(count($name) > 1){
					$fname = $name[0];
					$lname = $name[1];
				}else{
					$fname = '';
					$lname = $name[0];
				}
				echo '<font style="color:red;"><b>firstname</b>: '.@$fname.'<b>lastname</b>: '.@$lname.' <b>nominal</b>: '.@$thename[1].'('.$det['name'].') </font><br/>';
				$up_data = array(
					'valid_name' => 0,
					'first_name' => @$fname,
					'last_name' => @$lname,
					'post_nominal' => @$thename[1]
				);
			//	$clean_id .= ', '.$det['id'];
			}
			$this->db->update('data_dentists_raw_distinct', $up_data, array('id' => $det['id']));
		}
	//	echo $clean_id;
	}
	function clean_profile_pic(){
		$this->db->order_by('dentist_description_image');
		$res = $this->db->get('data_dentists_raw_distinct');
		$dets = $res->result_array();
		foreach($dets AS $det){
			$images = explode('|',$det['dentist_description_image']);
			if($images[0] != '' && $images[0] != 'NA' && $images[0] != 'N/A' && $images[0] != 'n/a' && $images[0] != 'na' && $images[0] != 'Na'){
				$profile_pic = $images[0];
			}else{
				$images = explode('|',$det['dentist_image']);
				if($images[0] != '' && $images[0] != 'NA' && $images[0] != 'N/A' && $images[0] != 'n/a' && $images[0] != 'na' && $images[0] != 'Na'){
					$profile_pic = $images[0];
				}else{
					$profile_pic = '';
				}
			}
		//	echo '('.$det['dentist_description_image'].' - '.$det['dentist_image'].') <br>';
		//	echo '<br>';
			$profile_pic = str_replace('jpeg','jpg',$profile_pic);
			$profile_pic = str_replace('PNG','png',$profile_pic);
			
			$up_data = array(
				'prof_pic' => $profile_pic
			);
			$this->db->update('data_dentists_raw_distinct', $up_data, array('id' => $det['id']));
		}
		echo $ids;
	}
	function check_profile_pic_ext(){
		$this->db->order_by('prof_pic');
		$res = $this->db->get('data_dentists_raw_distinct');
		$dets = $res->result_array();
		foreach($dets AS $det){
			$profile_pic = $det['prof_pic'];
			$profile_pic = substr($profile_pic,0,-4);
			if($profile_pic){
				$path = './user_assets/prof_images/extracted/';
				if(file_exists($path.$profile_pic.'.jpg')){
					$profile_pic = $profile_pic.'.jpg';
				}else if(file_exists($path.$profile_pic.'.png')){
					$profile_pic = $profile_pic.'.png';
				}else if(file_exists($path.$profile_pic.'.gif')){
					$profile_pic = $profile_pic.'.gif';
				}else{
					//echo '<b>'.$det['prof_pic'].'</b><br/>';
					$profile_pic = $det['prof_pic'];
					@$ids .= ', '.$det['id'];
				}
			}else{
				$profile_pic = '';
			}
			$up_data = array(
				'prof_pic' => $profile_pic
			);
			$this->db->update('data_dentists_raw_distinct', $up_data, array('id' => $det['id']));
		}
		echo $ids;
	}
	function check_profile_pic_filename(){
		$this->db->order_by('prof_pic');
		$res = $this->db->get('data_dentists_raw_distinct');
		$dets = $res->result_array();
		foreach($dets AS $det){
			$profile_pic = $det['prof_pic'];
			if($profile_pic){
				$path = './user_assets/prof_images/extracted/';
				if(file_exists($path.$profile_pic)){
			//		echo 'PASSED: '.$profile_pic.'<br/>';
				}else{
					echo '<b>'.$profile_pic.'</b><br/>';
					@$ids .= ', '.$det['id'];
				}
			}else{
			//	echo 'NO IMAGE ('.$det['dentist_description_image'].' - '.$det['dentist_image'].')<br/>';
			}
		}
		echo @$ids;
	}
	function clean_addresses(){
		$res = $this->db->get('data_dentists_raw_distinct');
		$dets = $res->result_array();
		foreach($dets AS $det){
			$address = $det['address'];
			$address = str_replace('#','',$address);
			$up_data = array(
				'address' => $address
			);
			$this->db->update('data_dentists_raw_distinct', $up_data, array('id' => $det['id']));
		}
	}
	function clean_user_addresses(){
		$res = $this->db->get('user_company_info');
		$dets = $res->result_array();
		foreach($dets AS $det){
			$address = $det['address'];
			$address = str_replace('#','',$address);
			$up_data = array(
				'address' => $address
			);
			$this->db->update('user_company_info', $up_data, array('id' => $det['id']));
		}
	}
	function transfer_users(){
	//	$this->db->limit(100);
		$res = $this->db->get('data_dentists_raw_distinct');
		$dets = $res->result_array();
		foreach($dets AS $det){
			//create account
			$login = $det['login_email'];
			$password = explode('@',$login);
			$password = $password[0];
			$salt = random_string('alnum',40);
			$adata = array(
			   'email' => $login,
			   'password' => dohash($salt.$password),
			   'salt' => $salt,
			   'status' => 1,
			   'date'	=> date('Y-m-d'),
			   'plan_id' => 7
			);
			$this->db->insert('user_accounts', $adata); 
			$user_id = $this->db->insert_id();
			
			//create personal info
			$pdata = array(
				'first_name' => $det['first_name'],
				'last_name' => $det['last_name'],
				'post_nominal' => $det['post_nominal'],
				'bio' => $det['bio'],
				'user_id' => $user_id,
				'prof_pic' => ret_alt_echo($det['prof_pic'],'','extracted/','')
			);
			$this->db->insert('user_personal_info', $pdata);
			
			//create company info
			$cdata = array(
				'company_name' => $det['company_name'],
				'address' => $det['address'],
				'city' => $det['city'],
				'state' => $det['state'],
				'zip' => $det['zip'],
				'telephone' => $det['phone'],
				'website' => $det['website'],
				'company_email' => $login,
				'user_id' => $user_id
			);
			$this->db->insert('user_company_info', $cdata);
			
			//create dashboard info
			$ddata = array(
			   'user_id' => $user_id
			);
			$this->db->insert('user_dashboard_info', $ddata);
			
			//create statistics
			$data = array(
				'user_id' => $user_id,
				'page_view' => 0,
			);
			$this->db->insert('user_statistics',$data);
			
			//link via user_id
			$up_data = array(
				'user_id' => $user_id
			);
			$this->db->update('data_dentists_raw_distinct', $up_data, array('id' => $det['id']));
		}
	}
}
/* End of file */