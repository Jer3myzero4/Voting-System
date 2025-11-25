<?php

require_once ROOT_DIR . '/vendor/autoload.php';
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');



use Dompdf\Dompdf;
class ElectionResults extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->lauth->protect_page();
    }


    public function index()
    {
        
        $results = $this->Election_Model->get_results();

        
        $positions = [];
        foreach ($results as $row) {
            $positions[$row['position']][] = $row;
        }

       
        $this->call->view('admin_pages/election_results', [
            'positions' => $positions
        ]);
    }


    public function print_winners()
{
    $leaders = $this->Election_Model->get_leading_candidates();

   
    $winners = array_filter($leaders, function($c) {
        return $c['status'] === 'Leading' || $c['status'] === 'Tied';
    });

    
    $this->call->view('admin_pages/print_winners', [
        'winners' => $winners
    ]);
}

 public function export_winners_pdf()
    {
        $leaders = $this->Election_Model->get_leading_candidates();
        $winners = array_filter($leaders, fn($c) => $c['status'] === 'Leading' || $c['status'] === 'Tied');

       
        ob_start();
        $this->call->view('admin_pages/print_winners', ['winners' => $winners]);
        $html = ob_get_clean();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("election_winners.pdf", ["Attachment" => true]);
    }



public function leading()
{

    
        $results = $this->Election_Model->get_results();

      
        $positions = [];
        foreach ($results as $row) {
            $positions[$row['position']][] = $row;
        }

       
        $this->call->view('students_pages/leading_candidates', [
            'positions' => $positions
        ]);
   
}









 

}
