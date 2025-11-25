<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class CandidateController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->lauth->protect_page(); 
    }


    public function get_all_candidates($current_page = 1) {
   
    $this->call->library('pagination');

    
    $query = trim($this->io->get('q') ?? '');
    

    
    $current_page = (int) $current_page ?: 1;

   
    $rows_per_page = 9;

   
    if ($query !== '') {
        $total_rows = $this->Candidate_Model->count_search_results($query);
    } else {
        $total_rows = $this->Candidate_Model->count_all();
    }

    
    $base_url = 'manage-candidates';
    if ($query !== '') $base_url .= '?q=' . urlencode($query);

   
    $this->pagination->initialize($total_rows, $rows_per_page, $current_page, $base_url, 5);

    
    $this->pagination->set_theme('tailwind');
    $this->pagination->set_custom_classes([
        'ul' => 'flex space-x-2',
        'li' => 'px-1',
        'a'  => 'px-3 py-1 rounded bg-gray-100 hover:bg-gray-200'
    ]);
    $this->pagination->set_options([
        'first_link' => '<< First',
        'last_link'  => 'Last >>',
        'next_link'  => 'Next >',
        'prev_link'  => '< Prev'
    ]);

    
    $offset = ($current_page - 1) * $rows_per_page;
    $limit_clause = "LIMIT {$offset}, {$rows_per_page}";

    
    if ($query !== '') {
        $candidates = $this->Candidate_Model->search_candidates($query, $limit_clause);
    } else {
        $candidates = $this->Candidate_Model->get_paginated($limit_clause);
    }

   
    $this->call->view('admin_pages/manage_candidates', [
        'candidates' => $candidates,
        'pagination' => $this->pagination->paginate(),
        'query'      => $query 
    ]);
}



























    public function create() {
    if ($this->form_validation->submitted()) {
        $fullname = $this->io->post('fullname');


        $existing = $this->Candidate_Model->get_by_fullname($fullname);

if ($existing) {
    $this->session->set_flashdata('error', 'This candidate is already a candidate.');
    redirect('/manage-candidates');
} else {
    $data = [
        'fullname'    => $fullname,
        'position'    => $this->io->post('position'),
        'grade_level' => $this->io->post('grade_level')
    ];

    $this->Candidate_Model->insert_candidate($data);
    $this->session->set_flashdata('success', 'Candidate added successfully.');
    redirect('/manage-candidates');
}


        // Check if fullname already exists
    }
}




















   public function update()
{
    $id = $this->io->post('id'); 
    $fullname = $this->io->post('fullname'); // Candidate ID from form

    $existing = $this->Candidate_Model->get_by_fullname($fullname, $id);

    if ($existing) {
    // Duplicate found
    $this->session->set_flashdata('error', 'This fullname is already assigned to another candidate.');
    redirect('/manage-candidates');
}

    if ($this->form_validation->submitted()) {
        $this->form_validation
             ->name('fullname')->required('Full Name is required')
             ->name('position')->required('Position is required')
             ->name('grade_level')->required('Grade Level is required');

        if ($this->form_validation->run()) {

            $fullname = $this->io->post('fullname');

            // ✅ Check if fullname already exists in another candidate
            $existing = $this->Candidate_Model->get_by_fullname($fullname);

            if (is_array($existing) && $existing['id'] != $id) {
                // Duplicate found, use SweetAlert2 via flashdata
                $this->session->set_flashdata('error', 'This fullname is already assigned to another candidate.');
                redirect('/manage-candidates');
            }

            $data = [
                'fullname'    => $fullname,
                'position'    => $this->io->post('position'),
                'grade_level' => $this->io->post('grade_level'),
            ];

            $this->Candidate_Model->update_candidate($id, $data);

            // ✅ Success notification
            $this->session->set_flashdata('success', 'Candidate updated successfully.');
            redirect('/manage-candidates');

        } else {
            $errors = $this->form_validation->get_errors();
            $this->call->view('admin_pages/manage_candidates_edit', [
                'errors'    => $errors,
                'candidate' => $this->Candidate_Model->get_by_id($id)
            ]);
        }

    } else {
        redirect('/manage-candidates');
    }
}























public function delete($id)
{
    $this->Candidate_Model->delete_candidate($id);
    redirect('/manage-candidates');
}




    
}
