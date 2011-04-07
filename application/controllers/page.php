<?php
class Page extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('form_validation');
	}

	public function index()
	{		
		$this->load->view('header');
		$this->load->view('home');
		$this->load->view('footer');
	}
	
	public function load($page)
	{
		$row = $this->db->get_where('catchair', array('id' => 1), 1)->row();
		
		$data['my_name'] = $row->my_name;
		$data['bro_name'] = $row->bro_name;
		$data['friend_name'] = $row->friend_name;
		$data['cat_name'] = $row->cat_name;
		
		if ($page == "two" || $page == "dream") {
			$this->load->view('header2');
		} elseif ($page == "four") {
			$this->load->view('header4');
		} elseif ($page == "three" || $page == "cat"){
			$this->load->view('header3');
		} else {
			$this->load->view('header');
		}
		$this->load->view($page, $data);
		$this->load->view('footer');
	}
	
	public function submit()
	{
		$this->load->library('security');
		//Rules
		$this->form_validation->set_rules('my_name', 'Your Name', 'min_length[2]|max_length[60]|xss_clean');
		$this->form_validation->set_rules('bro_name', 'Your Brother&rsquo; Name', 'min_length[2]|max_length[60]');
		
		if ($this->form_validation->run() == FALSE)
		{
			//Validation Fail
			redirect("/two");
		}
		else
		{
			$post = $this->security->xss_clean($_POST);
			if ($post["my_name"] != "" && $post["bro_name"] != "") {
				$this->db->update('catchair', $post, "id = 1");
				redirect("/two");
			} elseif ($post["my_name"] != "" && $post["bro_name"] == "") {
				$temp["my_name"]=$post["my_name"];
				$this->db->update('catchair', $temp, "id = 1");
				redirect("/two");
			} elseif ($post["my_name"] == "" && $post["bro_name"] != "") {
				$temp["bro_name"]=$post["bro_name"];
				$this->db->update('catchair', $temp, "id = 1");
				redirect("/two");
			} else {
				redirect("/two");
			}
		}
		
	}
	
	public function bestfriend()
	{
		$this->load->library('security');
		//Rules
		$this->form_validation->set_rules('friend_name', 'Your Best Friend&rsquo; Name', 'min_length[2]|max_length[60]|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
			//Validation Fail
			redirect("/three");
		}
		else
		{
			$post = $this->security->xss_clean($_POST);
			if ($post["friend_name"] != "") {
				$this->db->update('catchair', $post, "id = 1");
				redirect("/three");
			} else {
				redirect("/three");
			}
		}
		
	}
	
	public function catawesome()
	{
		$this->load->library('security');
		//Rules
		$this->form_validation->set_rules('cat_name', 'The Evil Cat&rsquo; Name', 'min_length[2]|max_length[60]|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
			//Validation Fail
			redirect("/four");
		}
		else
		{
			$post = $this->security->xss_clean($_POST);
			if ($post["cat_name"] != "") {
				$this->db->update('catchair', $post, "id = 1");
				redirect("/four");
			} else {
				redirect("/four");
			}
		}
		
	}
}
?>