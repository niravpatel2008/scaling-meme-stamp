<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index()
	{

		$session = $this->session->userdata('user_session');
		#pr($session,1);
		if (isset($session['id'])) {
			redirect(admin_path()."dashboard");
		}

		$data = array();
		$post = $this->input->post();
		if ($post) {
			$error = array();
			$e_flag=0;
			if(trim($post['userid']) == ''){
				$error['userid'] = 'Please enter userid.';
				$e_flag=1;
			}
			if(trim($post['password']) == ''){
				$error['password'] = 'Please enter password.';
				$e_flag=1;
			}

			if ($e_flag == 0) {
				$where = array('EmailId' => $post['userid'],
								'Password' => sha1($post['password']),
								'Role !=' => 'u'
							 );
				$user = $this->common_model->selectData(TBLUSER, '*', $where);
				if (count($user) > 0) {
					# create session
					$data = array('id' => $user[0]->id,
									'uname' => $user[0]->Firstname,
									'contact' => $user[0]->Mobileno,
									'email' => $user[0]->EmailId,
									'role' => $user[0]->Role,
									'create_date' => $user[0]->Createdate
								);
					$this->session->set_userdata('user_session',$data);
					redirect('admin/dashboard');
				}else{
					$error['invalid_login'] = "Invalid userid or password";
				}
			}

			$data['error_msg'] = $error;


		}

		$this->load->view('admin/index/index', $data);
	}


	public function logout()
	{
		$this->session->sess_destroy();
		redirect(admin_path());
	}



	public function forgotpassword()
	{
		$data = '';
		$post = $this->input->post();
		if ($post) {
			$error = array();
			$e_flag=0;
			if(!valid_email(trim($post['email'])) && trim($post['email']) == ''){
				$error['email'] = 'Please enter email.';
				$e_flag=1;
			}

			if ($e_flag == 0) {
				$where = array('EmailId' => trim($post['email']));
				$user = $this->common_model->selectData(TBLUSER, '*', $where);
				if (count($user) > 0) {

					echo $newpassword = random_string('alnum', 8);
					$data = array('Password' => sha1($newpassword));
					$upid = $this->common_model->updateData(TBLUSER,$data,$where);

					$login_details = array('username' => $user[0]->Firstname,'password' => $newpassword);
					#$emailTpl = $this->get_forgotpassword_tpl($login_details);

					$emailTpl = $this->load->view('email_templates/admin_forgot_password', '', true);

					$search = array('{username}', '{password}');
					$replace = array($login_details['username'], $login_details['password']);
					$emailTpl = str_replace($search, $replace, $emailTpl);

					$ret = sendEmail($user[0]->EmailId, SUBJECT_LOGIN_INFO, $emailTpl, FROM_EMAIL, FROM_NAME);
					if ($ret) {
						$flash_arr = array('flash_type' => 'success',
										'flash_msg' => 'Login details sent successfully.'
									);
					}else{
						$flash_arr = array('flash_type' => 'error',
										'flash_msg' => 'An error occurred while processing.'
									);
					}
					$data['flash_msg'] = $flash_arr;
				}else{
					$error['email'] = "Invalid email address.";
				}
			}
			$data['error_msg'] = $error;
		}
		$this->load->view('admin/index/forgotpassword', $data);
	}

}
