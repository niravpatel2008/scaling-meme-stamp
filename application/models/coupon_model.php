<?php
class coupon_model extends CI_Model{
	public function  __construct(){
		parent::__construct();
		$this->load->database();
	}


    /**
    * check coupon code fields
    */
    public function checkCoupon($code)
    {
        $this->db->select('*');
        $this->db->from(TBLCOUPON);
        $this->db->where('Startdate <=',date('Y-m-d'));
        $this->db->where('Enddate >',date('Y-m-d'));
        $this->db->where('Code',$code);

        $query = $this->db->get();
        $data =$query->row();
        $query->free_result();

        return $data;
    }


}
