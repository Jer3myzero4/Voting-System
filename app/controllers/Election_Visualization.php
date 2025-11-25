<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Election_Visualization extends Controller
{
   public function __construct()
    {
        parent::__construct();
        $this->lauth->protect_page(); 
    }


    public function index()
    {
       
        $results = $this->Election_Model->get_vote_summary();

    
        $chart_data = [];
        foreach ($results as $row) {
            $chart_data[$row['position']][] = [
                'candidate_name' => $row['candidate_name'],
                'total_votes' => (int)$row['total_votes']
            ];
        }

        
        $this->call->view('admin_pages/visualization', ['chart_data' => $chart_data]);
    }
}
