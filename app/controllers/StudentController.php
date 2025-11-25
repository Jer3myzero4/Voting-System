<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller {


public function __construct()
    {
        parent::__construct();
        $this->lauth->protect_page(); 
    }




    public function student_dashboard(){
    

        
    $register_id = $this->session->userdata('register_id'); 
    $fullname = $this->lauth->get_fullname($register_id);

       $this->call->view('students_pages/student_dashboard', [
        'fullname' => $fullname
    ]);
            
    }

     public function my_votes(){
        $this->call->view('students_pages/my_votes');
    }


     public function vote_now(){
        $this->call->view('students_pages/vote_now');
    }


}
?>
