<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct(){
		parent::__construct();

		is_login();

		$this->user_session = $this->session->userdata('user_session');

		if (!@in_array("users", @array_keys(config_item('user_role')[$this->user_session['role']])) && $this->user_session['role'] != 'a') {
			redirect("admin/dashboard");
		}
	}

	public function index()
	{
		#pr($this->session->flashdata('flash_msg'));
		$data['view'] = "index";
		$this->load->view('admin/content', $data);
	}

	public function ajax_list($limit=0)
	{
		$post = $this->input->post();

		$columns = array(
			array( 'db' => 'Firstname', 'dt' => 0 ),
			array( 'db' => 'Lastname',  'dt' => 1 ),
			array( 'db' => 'EmailId',  'dt' => 2 ),
			array( 'db' => 'Mobileno',  'dt' => 3 ),
			array( 'db' => 'City',  'dt' => 4 ),
			array( 'db' => 'Status',  'dt' => 5 ),
			array('db'        => 'Createdate',
					'dt'        => 6,
					'formatter' => function( $d, $row ) {
						return date( 'jS M y', strtotime($d));
					}
			),
			array( 'db' => 'id',
					'dt' => 7,
					'formatter' => function( $d, $row ) {
						return '<a href="'.site_url('/admin/users/edit/'.$d).'" class="fa fa-edit"></a> <a href="javascript:void(0);" onclick="delete_user('.$d.')" class="fa fa-trash-o"></a>';
					}
			),
		);
		echo json_encode( SSP::simple( $post, TBLUSER, "id", $columns ) );exit;
	}

	public function add()
	{
		$post = $this->input->post();
		if ($post) {
			#pr($post);
			$error = array();
			$e_flag=0;

			if(trim($post['Mobileno']) == ""){
				$error['Mobileno'] = 'Please enter mobile number.';
				$e_flag=1;
			}
			else{
				$is_unique_email = $this->common_model->isUnique(TBLUSER, 'Mobileno', trim($post['Mobileno']));
				if (!$is_unique_email) {
					$error['Mobileno'] = 'Mobile number already exists.';
					$e_flag=1;
				}
			}

			if(trim($post['Firstname']) == ''){
				$error['Firstname'] = 'Please enter first name.';
				$e_flag=1;
			}
			
			if(!valid_email(trim($post['EmailId'])) && trim($post['EmailId']) == ''){
				$error['EmailId'] = 'Please enter valid email.';
				$e_flag=1;
			}
			if(trim($post['Role']) == ''){
				$error['Role'] = 'Please select role.';
				$e_flag=1;
			}
			
			
			if (trim($post['Password']) != "") {
				if($post['Password'] == $post['re_Password'])
				{
					$psFlas = true;
				}
				else
				{
					$error['Password'] = 'Password field does not match.';
					$e_flag=1;
				}
			}
			else
			{
				$error['Password'] = 'Please enter password.';
				$e_flag=1;
			}

			if ($e_flag == 0) {
				$data = array('Firstname' => $post['Firstname'],
								'Lastname' => $post['Lastname'],
								'EmailId' => $post['EmailId'],
								'Role' => $post['Role'],
								'Mobileno' => $post['Mobileno'],
								'Password' => sha1(trim($post['Password'])),
								'City' => $post['City'],
								'State' => $post['State'],
								'Status' => $post['Status'],
							);
				
				$ret = $this->common_model->insertData(TBLUSER, $data);

				if ($ret > 0) {
					$flash_arr = array('flash_type' => 'success',
										'flash_msg' => 'User added successfully.'
									);
				}else{
					$flash_arr = array('flash_type' => 'error',
										'flash_msg' => 'An error occurred while processing.'
									);
				}
				$this->session->set_flashdata($flash_arr);
				redirect("admin/users");
			}
			$data['error_msg'] = $error;
		}
		$data['view'] = "add_edit";
		$this->load->view('admin/content', $data);
	}

	public function edit($id)
	{
		if ($id == "" || $id <= 0) {
			redirect('admin/users');
		}

		$where = 'id = '.$id;

		$post = $this->input->post();
		if ($post) {
			#pr($post);
			$error = array();
			$e_flag=0;

			if(trim($post['Mobileno']) == ""){
				$error['Mobileno'] = 'Please enter mobile number.';
				$e_flag=1;
			}
			else{
				$is_unique_email = $this->common_model->isUnique(TBLUSER, 'Mobileno', trim($post['Mobileno']));
				if (!$is_unique_email) {
					$error['Mobileno'] = 'Mobile number already exists.';
					$e_flag=1;
				}
			}

			if(trim($post['Firstname']) == ''){
				$error['Firstname'] = 'Please enter first name.';
				$e_flag=1;
			}
			if(!valid_email(trim($post['EmailId'])) && trim($post['EmailId']) == ''){
				$error['EmailId'] = 'Please enter valid email.';
				$e_flag=1;
			}
			if(trim($post['Role']) == ''){
				$error['Role'] = 'Please select role.';
				$e_flag=1;
			}
			if(trim($post['Mobileno']) == ''){
				$error['Mobileno'] = 'Please enter contact number.';
				$e_flag=1;
			}
			$psFlas = false;
			if (trim($post['Password']) != "") {
				if($post['Password'] == $post['re_Password'])
				{
					$psFlas = true;
				}
				else
				{
					$error['Password'] = 'Password field does not match.';
					$e_flag=1;
				}
			}

			if ($e_flag == 0) {
				$data = array('Firstname' => $post['Firstname'],
								  'Lastname' => $post['Lastname'],
								 'Role' => $post['Role'],
								'Mobileno' => $post['Mobileno'],
								'EmailId' => $post['EmailId'],
								'City' => $post['City'],
								'State' => $post['State'],
								'Status' => $post['Status'],
								'Updatedate' => date('Y-m-d H:i:s'),
							);
				if($psFlas)
					$data['Password'] = sha1(trim($post['Password']));
				$ret = $this->common_model->updateData(TBLUSER, $data, $where);

				if ($ret > 0) {
					$flash_arr = array('flash_type' => 'success',
										'flash_msg' => 'User updated successfully.'
									);
				}else{
					$flash_arr = array('flash_type' => 'error',
										'flash_msg' => 'An error occurred while processing.'
									);
				}
				$this->session->set_flashdata($flash_arr);
				redirect("admin/users");
			}
			$data['error_msg'] = $error;
		}
		$data['user'] = $user = $this->common_model->selectData(TBLUSER, '*', $where);

		if (empty($user)) {
			redirect('admin/users');
		}
		$data['view'] = "add_edit";
		$this->load->view('admin/content', $data);
	}


	public function delete()
	{
		$post = $this->input->post();

		if ($post) {
			$ret = $this->common_model->deleteData(TBLUSER, array('id' => $post['id'] ));
			if ($ret > 0) {
				echo "success";
				#echo success_msg_box('User deleted successfully.');;
			}else{
				echo "error";
				#echo error_msg_box('An error occurred while processing.');
			}
		}
	}
}
