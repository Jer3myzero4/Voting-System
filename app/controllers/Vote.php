 <?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Vote extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->model('Candidate_Model');
        $this->call->model('Vote_Model');
        $this->call->library('session');
    }

    // ✅ Show voting page
    public function vote_now() {
        $voter_id = $this->session->userdata('register_id');

        // Check if user has already voted for all positions
        $voted_positions = $this->Vote_Model->get_voted_positions($voter_id);
        $all_positions   = $this->Candidate_Model->get_all_positions();

        $data['already_voted'] = count($voted_positions) >= count($all_positions);
        $data['grouped_candidates'] = $this->Candidate_Model->get_all_candidates_grouped_by_position();
        $data['notification'] = $this->session->flashdata('notification') ?? null;
        
        $this->call->view('students_pages/vote_now', $data);
    }

    // ✅ Handle vote submission
    public function submit_vote() {
        $voter_id = $this->session->userdata('register_id');
        $votes = $this->io->post('votes'); // ['President' => candidate_id, 'Vice President' => candidate_id]

        if (empty($voter_id)) {
            $this->session->set_flashdata('notification', json_encode([
                'icon' => 'error',
                'title' => 'Session Expired',
                'text' => 'Please log in again to continue voting.'
            ]));
            redirect('/login');
            return;
        }

        // ✅ Get all required positions
        $all_positions = $this->Candidate_Model->get_all_positions();

        // ✅ Check for missing votes
        $missing_positions = [];
        foreach ($all_positions as $position) {
            if (!isset($votes[$position]) || empty($votes[$position])) {
                $missing_positions[] = $position;
            }
        }

        if (!empty($missing_positions)) {
            $this->session->set_flashdata('notification', json_encode([
                'icon' => 'error',
                'title' => 'Incomplete Vote',
                'text' => 'Please select a candidate for all positions before submitting your vote.'
            ]));
            redirect('/vote-now');
            return;
        }

        // ✅ Insert votes only for positions not yet voted
        foreach ($votes as $position => $candidate_id) {
            if (!$this->Vote_Model->has_voted($voter_id, $position)) {
                $candidate = $this->Candidate_Model->get_candidate_by_id($candidate_id);
                if (!$candidate) continue;

                $this->Vote_Model->insert_vote([
                    'register_id'    => $voter_id,
                    'candidate_id'   => $candidate_id,
                    'position'       => $position,
                    'candidate_name' => $candidate['fullname']
                ]);
            }
        }

        $this->session->set_flashdata('notification', json_encode([
            'icon' => 'success',
            'title' => 'Vote Submitted!',
            'text' => 'Your votes have been recorded successfully.'
        ]));

        redirect('/vote-now');
    }















    public function my_votes()
{
    $voter_id = $this->session->userdata('register_id');

    if (empty($voter_id)) {
        redirect('/login');
        return;
    }

    $data['my_votes'] = $this->Vote_Model->get_votes_by_voter($voter_id);
    $this->call->view('students_pages/my_votes', $data);
}





}
