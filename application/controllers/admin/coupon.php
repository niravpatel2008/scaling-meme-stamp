<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends CI_Controller {

	function __construct(){
		parent::__construct();

		is_login();

		$this->user_session = $this->session->userdata('user_session');

	}

	public function index()
	{

		if ($this->user_session['role'] == 'a')
		{
			$users = $this->common_model->selectData(TBLUSER, 'id,Firstname,EmailId', array("Status"=>'Active','Role'=>'d'));
			$data['users'] = $users;
		}

		$coupons = $this->common_model->selectData(TBLCOUPON, 'id,Name,Type', array("tblUser_id"=>$this->user_session['id']));
		$data['coupons'] = $coupons;

		$data['view'] = "index";
		$this->load->view('admin/content', $data);
	}

	public function code_list()
	{
		$post = $this->input->post();

		$columns = array(
			array( 'db' => 'code',  'dt' => 0 ),
			array( 'db' => 'Firstname',  'dt' => 1 ),
			array( 'db' => 'Mobileno', 'dt' => 4 ),
			array('db'        => 'used_date',
					'dt'        => 8,
					'formatter' => function( $d, $row ) {
						return date( 'jS M y', strtotime($d));
					}
			),
			array( 'db' => 'CONCAT(tblcode.id,"|",tblcode.status)',
					'dt' => 9,
					'formatter' => function( $d, $row ) {
						list($id,$status) = explode("|",$d);
						return '<a href="javascript:void(0);" data-tblcode_id="'.$id.'" class="fa fa-eye code-status '.$status.'"></a>';
					}
			),
		);
		
		$join = array(TBLUSER,'tbluser.id = tblcode.tblUser_id',"left");
		$custom_where = array('tblCoupon_id'=>$post['tblcoupon_id']);
		
		/*if($this->user_session['role'] == 'd') {
			$custom_where = array('tblcoupon.tblUser_id'=>$this->user_session['dealer_info']->id);
		}*/
		
		echo json_encode( SSP::simple( $post, TBLCODE, "tblcode.id", $columns ,array($join),$custom_where) );exit;

	}

	public function coupon_list()
	{
		$post = $this->input->post();
		$userId = trim($post['tblUser_id']);
		if ($userId == "")
		$user = $this->common_model->selectData(TBLCOUPON, 'id,name,Status', array('tblUser_id'=>$userId,''));
		echo json_encode($user);
	}

	public function add()
	{
		$post = $this->input->post();
		if (!$post) redirect("admin/coupon");
	
		$this->form_validation->set_rules('coupon_name', 'Coupon Name', 'trim|required');
		$this->form_validation->set_rules('coupon_type', 'Type', 'trim|required');
		$this->form_validation->set_rules('coupon_status', 'Status', 'trim|required');
		$this->form_validation->set_rules('coupon_count', 'Count', 'trim|required|integer');
		$this->form_validation->set_rules('coupon_timeperiod', 'Start & End Date', 'trim|required');
		if($post['coupon_type'] == "Offer")
		{
			$this->form_validation->set_rules('coupon_disounton', 'Discount on minimum recharge', 'trim|required');
		}
		if ($this->form_validation->run())
		{
			$insertdata = array();
			$insertdata['Name'] = $post['coupon_name'];
			$insertdata['Type'] = $post['coupon_type'];
			$insertdata['tblUser_id'] = (isset($post['tblUser_id']) && $post['tblUser_id']!="")?$post['tblUser_id']:$this->user_session['id'];
			if ($insertdata['Type'] == "Offer")
				$insertdata['DiscountPrice'] = $post['coupon_disounton'];
			
			$timeperiod = explode("-",$post['coupon_timeperiod']);
			$insertdata['Startdate'] = date('Y-m-d H:i:s',strtotime($timeperiod[0]));
			$insertdata['Enddate'] = date('Y-m-d H:i:s',strtotime($timeperiod[1]));	
			$insertdata['Amount'] = $post['coupon_price'];
			$insertdata['Status'] = $post['coupon_status'];
			$insertdata['Updatedate'] = date('Y-m-d');
			
			$ret = $this->common_model->insertData(TBLCOUPON, $insertdata);
			if ($ret > 0) {
				for ( $i=0; $i < $post['coupon_count']; $i++ ){
					$number = base64_encode(openssl_random_pseudo_bytes(20));
					$newstr = preg_replace('/[^a-zA-Z0-9\']/', '', $number);
					$size = strlen($ret.$i);
					$code = substr($newstr,0,(10-$size));
					$code = $ret.$code.$i;

					$insertdata = array();
					$insertdata['code'] = $code;
					$insertdata['tblCoupon_id'] = $ret;
					$insertdata['status'] = 'Active';

					$retid = $this->common_model->insertData(TBLCODE, $insertdata);
				}
				$flash_arr = array('flash_type' => 'success',
											'flash_msg' => 'Coupon code generated successfully.'
										);
			}
			else
			{
				$flash_arr = array('flash_type' => 'error',
											'flash_msg' => 'An error occurred while processing.'
										);
			}
		}
		else
		{ 
			$flash_arr = array('flash_type' => 'error','flash_msg' => validation_errors('', '')); 
		}
		$this->session->set_flashdata($flash_arr);
		redirect("admin/coupon");
	}
}