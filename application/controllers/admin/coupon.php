<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends CI_Controller {

	function __construct(){
		parent::__construct();

		is_login();

		$this->user_session = $this->session->userdata('user_session');

	}

	public function index()
	{
		#pr($this->user_session);
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
			array( 'db' => 'CONCAT(tblcode.id,"|",status)',
					'dt' => 9,
					'formatter' => function( $d, $row ) {
						list($id,$status) = explode("|",$d);
						return '<a href="javascript:void(0);" data-tblcode_id="'.$id.'" class="fa fa-eye code-status '.$status.'"></a>';
					}
			),
		);
		
		$join = array(TBLUSER,'tbluser.id = tblcode.tblUser_id');
		$custom_where = array('tblCoupon_id'=>$post['tblcoupon.id']);
		
		/*if($this->user_session['role'] == 'd') {
			$custom_where = array('tblcoupon.tblUser_id'=>$this->user_session['dealer_info']->id);
		}*/
		
		echo json_encode( SSP::simple( $post, TBLCOUPON, "id", $columns ,array($join),$custom_where) );exit;

	}

	public function user_list()
	{
		$user = $this->common_model->selectData(TBLUSER, 'id,Firstname,EmailId', array("Status"=>'Active','Role'=>'d'));
		echo json_encode($user);
	}

	public function coupon_list()
	{
		$post = $this->input->post();
		$userId = trim($post['tblUser_id']);
		if ($userId == "")
		$user = $this->common_model->selectData(TBLCOUPON, 'id,name,Status', array('tblUser_id'=>$userId,''));
		echo json_encode($user);
	}
}