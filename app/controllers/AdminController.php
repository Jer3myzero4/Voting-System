<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AdminController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->lauth->protect_page();
    }




    public function manage_voters()
{
    $search = $this->io->get('search'); 

    if (!empty($search)) {
       
        $data['voters'] = $this->Voters_Model->search_voters($search);
    } else {
        
        $data['voters'] = $this->Voters_Model->get_all_voters();
    }

    $this->call->view('admin_pages/manage_voters', $data);
}



    public function voters() {
        $this->call->view('admin_pages/manage_voters');
    }





   public function index()
{
   
    $this->call->model('Voters_Model');
    $this->call->model('Election_Model');

  
    $data = [
        'total_voters' => $this->Voters_Model->count_voters(),
        'total_candidates' => $this->Voters_Model->count_candidates(),
        'total_president_candidates' => $this->Voters_Model->count_president_candidates(),
        'total_vicepresident_candidates' => $this->Voters_Model->count_vicepresident_candidates(),
        'total_secretary_candidates' => $this->Voters_Model->count_secretary_candidates(),
        'total_treasurer_candidates' => $this->Voters_Model->count_treasurer_candidates(),
        'total_auditor_candidates' => $this->Voters_Model->count_auditor_candidates(),
        'total_pio_candidates' => $this->Voters_Model->count_pio_candidates(),
        'total_businessmanager_candidates' => $this->Voters_Model->count_businessmanager_candidates(),
        'total_muse_candidates' => $this->Voters_Model->count_muse_candidates(),
        'total_escort_candidates' => $this->Voters_Model->count_escort_candidates(),
    ];

    $data['total_pending_votes'] = $this->Voters_Model->count_pending_votes();


    
    $data['leaders'] = $this->Election_Model->get_leading_candidates();

    
    $this->call->view('admin_pages/admin', $data);
}


    
   

     



    public function election_results() {
        $this->call->view('admin_pages/election_results');
    }

	




   

}
?>
