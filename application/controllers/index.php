<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

    function __construct(){
        parent::__construct();
    }

	public function index()
	{
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
}

/* End of file index.php */
/* Location: ./application/controllers/index.php */
