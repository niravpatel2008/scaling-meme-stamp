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
			$isUnique=$this->common_model->isUnique(TBLUSER, 'mobileno', trim($post['mobileno']));

			#$this->form_validation->set_error_delimiters('<label class="form-error-msg"><i class="fa fa-times-circle-o"></i>', '</label><br/>');
			$this->form_validation->set_rules('mobileno', 'Mobile Number', 'trim|required');
			$this->form_validation->set_rules('provider', 'Provider', 'trim|required');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
			$this->form_validation->set_rules('username', 'Name', 'trim|required');
			$this->form_validation->set_rules('emailId', 'Email Address', 'trim|required|valid_email');
			#$this->form_validation->set_rules('state', 'State', 'trim|required');
			#$this->form_validation->set_rules('city', 'City', 'trim|required');
			if($isUnique)
			{
				$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[repassword]');
				$this->form_validation->set_rules('repassword', 'Repeat Password', 'required');
			}

			if ($this->form_validation->run()) {
				
				if($isUnique)
				{
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
				}
				else
				{
					$ret=$this->common_model->getId(TBLUSER, 'mobileno', trim($post['mobileno']));
				}
				if($ret)
				{
					if(isset($this->front_session['couponCode']) && $this->front_session['couponCode']!=0)
					{
						
					}
					else
					{
						$session_data=array('topupAmount'=>$post['amount'],'actualAmount'=>$post['amount']);
						$this->session->set_userdata('front_session',$session_data);
					}
					$this->front_session = $this->session->userdata('front_session');
					
					if(isset($this->front_session['topupAmount']) && isset($this->front_session['actualAmount']))
					{
						$uniqueNo=rand ( 10000 , 999999 );
						$inserttrans = array('tblUser_id' => $ret,
								'tblCircle_id' => $post['provider'],
								'tblState_id' => '',
								'Mobileno' => $post['mobileno'],
								'APIrequestId' => $uniqueNo,
								'APItransactionId' => '',
								'APIresponcecode' => '',
								'Amount' => $this->front_session['actualAmount'],
								'Userip' => $_SERVER['REMOTE_ADDR'],
								'Flag' => '',
								'Transactiondetail' => '',
								'Status' => 'Pending'
							);
							$trans = $this->common_model->insertData(TBLTRANSACTIONHISTORY, $inserttrans);
						
							$insertpaymenttrans = array('tblTransactionhistory_id' => $trans,
									'tblUser_id' => $post['provider'],
									'tblCoupon_id' => '',
									'Requestid' => '',
									'Transactionid' => '',
									'Token' => '',
									'Amount' => $this->front_session['topupAmount'],
									'Userip' => $_SERVER['REMOTE_ADDR'],
									'Paymentdetail' => '',
									'Status' => 'Pending'
								);
							$paymenttrans = $this->common_model->insertData(TBLPAYMENTHISTORY, $insertpaymenttrans);
							
							
							//=========================================================================
							//Payment Process will be here
							//=========================================================================
							
							
							$postdata = http_build_query(array('userid' => '5773646' // Login UserId
							, 'pass' => '5590' // Login password
							, 'mob' => $post['mobileno'] // Mobile number to recharge
							, 'opt' => $post['provider'] // Operator code given by API provider
							, 'amt' => $post['amount'] // Amount to recharge
							, 'agentid' => $uniqueNo // Our unique Id
							  ));
							$result=callrechargeAPI($postdata);
							if($result['Status']=="SUCCESS")
							{
								echo "user Recharge successfull";
								$updatetrans = array(
									'APItransactionId' => $result['Tid'],
									'APIresponcecode' => 'SUCCESS',
									'Transactiondetail' => json_decode($result),
									'Status' => 'Success'
								);
								$updatetrans = $this->common_model->updateData(TBLTRANSACTIONHISTORY, $updatetrans, 'id = '.$trans);
									
							}
							else if($result['Status']=="FAILED")
							{
								echo "user Recharge Fail due to ".$result['STATUS'];
								$updatetrans = array(
									'APItransactionId' => $result['Tid'],
									'APIresponcecode' => 'FAILED',
									'Transactiondetail' => json_decode($result),
									'Status' => 'Fail'
								);
								$trans = $this->common_model->updateData(TBLTRANSACTIONHISTORY, $updatetrans, 'id = '.$trans);
								//=========================================================================
								//Payment refund Process will be here
								//=========================================================================
							}
							else if($result['Status']=="REFUND")
							{
								echo "user Recharge refunded";
								echo "user Recharge Fail due to ".$result['STATUS'];
								$updatetrans = array(
									'APItransactionId' => $result['Tid'],
									'APIresponcecode' => 'REFUND',
									'Transactiondetail' => json_decode($result),
									'Status' => 'Fail'
								);
								$trans = $this->common_model->updateData(TBLTRANSACTIONHISTORY, $updatetrans, 'id = '.$trans);
								//=========================================================================
								//Payment refund Process will be here
								//=========================================================================
							}
							else
							{
								echo $result['STATUS'];
								echo "user Recharge Fail due to ".$result['STATUS'];
								$updatetrans = array(
									'APItransactionId' => $result['Tid'],
									'APIresponcecode' => '',
									'Transactiondetail' => json_decode($result),
									'Status' => 'Fail'
								);
								$trans = $this->common_model->updateData(TBLTRANSACTIONHISTORY, $updatetrans, 'id = '.$trans);
								//=========================================================================
								//Payment refund Process will be here
								//=========================================================================
							}
							
							
							pr($result,1);
						
					}
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
	public function checkuser()
	{
		$post = $this->input->post();
		if($post)
		{
			$isUnique=$this->common_model->isUnique(TBLUSER, 'mobileno', trim($post['mo']));
			if($isUnique)
			{
				echo 'Unique';
			}
			else 
			{
				echo "Exist";
			}
		}	
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
			$amount=$post['Amt'];
			$codeData=$this->common_model->checkCoupon($coupon);
			if(!empty($codeData))
			{
				if($codeData->Code==$coupon)
				{
					if($codeData->Type=='TopUp')
					{
						if($amount>$codeData->Amount)
						{
							$paymentAmt=$amount-$codeData->Amount;
						}
						else
						{
							$paymentAmt=0;
						}
						$session_data=array('topupAmount'=>$paymentAmt,'actualAmount'=>$amount,'couponCode'=>$codeData->id);
						$this->session->set_userdata('front_session',$session_data);
						$data=array('actualAmt'=>$amount,'paymentAmt'=>$paymentAmt,'status'=>"Success");
						echo json_encode($data);
					}
					else if ($codeData->Type=='Offer')
					{
						
					}
				}
				else
				{
					$data=array('status'=>"Error",'Message'=>"There is something wrong");
					echo json_encode($data);
				}
			}
			else
			{
				$data=array('status'=>"Error",'Message'=>"Wrong Coupon Code");
				echo json_encode($data);
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
