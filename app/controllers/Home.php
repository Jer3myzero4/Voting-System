<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Home extends Controller {

	


    
     public function index() {
		$this->call->view('home/landing_page');
	}

     public function about() {
		$this->call->view('home/about');
	}

     public function contact() {
		$this->call->view('home/contact');
	}

    
}
?>
