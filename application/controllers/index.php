<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

    function __construct(){
        parent::__construct();

		$this->front_session = $this->session->userdata('front_session');
		$this->form_validation->set_error_delimiters('<div id="errorMsg" class="12u errorMsg">','</div>');
		#pr($this->front_session,1);
    }
	public function index()
	{

		$post = $this->input->post();
		if($post)
		{
			#$is_unique_username = $this->common_model->isUnique(DEAL_USER, 'uname', trim($post['uname']));
			#$is_unique_email = $this->common_model->isUnique(DEAL_USER, 'email', trim($post['email']));


			#$this->form_validation->set_error_delimiters('<label class="form-error-msg"><i class="fa fa-times-circle-o"></i>', '</label><br/>');
			$this->form_validation->set_rules('mobileno', 'Mobile Number', 'trim|required');
			$this->form_validation->set_rules('provider', 'Provider', 'trim|required');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
			$this->form_validation->set_rules('username', 'Name', 'trim|required');
			$this->form_validation->set_rules('emailId', 'Email Address', 'trim|required|valid_email');
			#$this->form_validation->set_rules('state', 'State', 'trim|required');
			#$this->form_validation->set_rules('city', 'City', 'trim|required');
			#$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[repassword]');
			#$this->form_validation->set_rules('repassword', 'Repeat Password', 'required');

			if ($this->form_validation->run()) {
				$insertdata = array('Firstname' => $post['username'],
								'Role' => 'u',
								'EmailId' => $post['emailId'],
								'Mobileno' => $post['mobileno'],
								'Password' => md5($post['password']),
								'City' => '',
								'State' => '',
								'Status' => 'Guest'
							);
				$ret = $this->common_model->insertData(TBLUSER, $insertdata);
				if($ret)
				{
					$postdata = http_build_query(array('userid' => 'UserId' // Login UserId
					, 'pass' => 'Pass' // Login password
					, 'mob' => $post['mobileno'] // Mobile number to recharge
					, 'opt' => $post['provider'] // Operator code given by API provider
					, 'amt' => $post['amount'] // Amount to recharge
					, 'agentid' => '12335' // Our unique Id
					  ));
					$result=callrechargeAPI($postdata);
					pr($result,1);
				}
			}
			else
			{
				$data['userdetailError']=true;
			}
		}
		$data['view'] = "index";
		$this->load->view('content', $data);
	}
	public function articals()
	{
		$data['view'] = "articals";
		$this->load->view('content', $data);
	}
	public function aboutus()
	{
		$data['view'] = "aboutus";
		$this->load->view('content', $data);
	}
	public function contactus()
	{
		$data['view'] = "contactus";
		$this->load->view('content', $data);
	}
	public function applycoupon()
	{
		$post = $this->input->post();
		if($post)
		{
			$coupon=$post['Code'];
			$codeData=$this->common_model->checkCoupon($coupon);
			if(!empty($codeData))
			{
				pr($codeData);
			}
			else
			{
				echo "Wrong coupon code";
			}
		}
		exit;
	}
	public function getdetail()
	{
		$post = $this->input->post();
		$is_error=0;

		if(trim($post['Mn'])=='' && !isset($this->front_session['mobileno']))
		{
			$is_error=1;
		}
		if(trim($post['Pr'])=='' && !isset($this->front_session['provider']))
		{

			$is_error=1;
		}
		if(trim($post['Rm'])=='' && !isset($this->front_session['amount']))
		{

			$is_error=1;
		}

		if($is_error==0)
		{
			$session_data=array('mobileno'=>$post['Mn']
								,"provider"=>$post['Pr']
								,"amount"=>$post['Rm']);
			$this->session->set_userdata('front_session',$session_data);
			$data['view'] = "";
			$this->load->view('index/getdetail', $data);
		}
		else
		{
			echo "Error";
		}
	}

	public function signin()
	{

		$post = $this->input->post();
		if ($post) {
			$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|integer');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			if ($this->form_validation->run()) {
				$where = array('Mobileno' => $post['mobile'],
								'Password' => md5(trim($post['password'])),
								'Role' => 'u'
							 );
				$user = $this->common_model->selectData(TBLUSER, '*', $where);
				if (count($user) > 0) {
					# create session
					$data = array('id' => $user[0]->id,
									'mobile' => $user[0]->Mobileno
								);
					$this->session->set_userdata('front_session',$data);
					redirect(base_url());

				}else{
					$data['error_msg'] = "Invalid username or password";
				}
			}
		}

		$data['view'] = "login";
		$this->load->view('content', $data);
	}


	public function signout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}

}

/* End of file index.php */
/* Location: ./application/controllers/index.php */
