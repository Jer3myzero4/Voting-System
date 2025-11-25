<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Election_Model extends Model
{
    public function get_results()
    {
        $sql = "SELECT position, candidate_name, COUNT(*) AS total_votes 
                FROM votes 
                GROUP BY position, candidate_name 
                ORDER BY position ASC, total_votes DESC";

        $stmt = $this->db->raw($sql);
        return $stmt->fetchAll();
    }


    public function get_leading_candidates()
{
    // Step 1: Count votes per candidate per position
    $sql = "
        SELECT position, candidate_name, COUNT(*) AS total_votes
        FROM votes
        GROUP BY position, candidate_name
    ";
    $results = $this->db->raw($sql)->fetchAll();

    // Step 2: Find max votes per position
    $leaders = [];
    $grouped = [];

    foreach ($results as $row) {
        $grouped[$row['position']][] = $row;
    }

    foreach ($grouped as $position => $candidates) {
        // Find highest vote count for this position
        $maxVotes = max(array_column($candidates, 'total_votes'));

        // Get all candidates who have this max vote
        $winners = array_filter($candidates, function ($c) use ($maxVotes) {
            return $c['total_votes'] == $maxVotes;
        });

        if (count($winners) > 1) {
            // There’s a tie for this position
            foreach ($winners as $tie) {
                $leaders[] = [
                    'position' => $position,
                    'candidate_name' => $tie['candidate_name'],
                    'total_votes' => $tie['total_votes'],
                    'status' => 'Tied'
                ];
            }
        } else {
            // Only one clear leader
            $winner = reset($winners);
            $leaders[] = [
                'position' => $position,
                'candidate_name' => $winner['candidate_name'],
                'total_votes' => $winner['total_votes'],
                'status' => 'Leading'
            ];
        }
    }

    return $leaders;
}



       public function get_vote_summary()
    {
        $sql = "SELECT position, candidate_name, COUNT(*) AS total_votes 
                FROM votes 
                GROUP BY position, candidate_name 
                ORDER BY FIELD(position, 
                    'President', 
                    'Vice President', 
                    'Secretary', 
                    'Treasurer', 
                    'Auditor', 
                    'PIO', 
                    'Business Manager', 
                    'Muse', 
                    'Escort')";

        // ✅ Use LavaLust's raw() for direct SQL
        $stmt = $this->db->raw($sql);

        // ✅ Then fetch all records as associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function update_winners($leaders)
{
    foreach ($leaders as $winner) {
        $this->db->table('candidates')
                 ->where('id', $winner['id'])
                 ->update(['is_winner' => 1]);
    }
}

public function update_election_status($status)
{
    $this->db->table('elections')
             ->update(['status' => $status]);
}




}
