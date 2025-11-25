<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Vote_Model extends Model
{
    protected $table = 'votes';

    // ✅ Check if voter already voted for a position
    public function has_voted($register_id, $position)
    {
        $sql = "SELECT COUNT(*) AS total 
                FROM {$this->table} 
                WHERE register_id = :register_id 
                AND position = :position";

        $stmt = $this->db->raw($sql, [
            ':register_id' => $register_id,
            ':position'    => $position
        ]);

        $row = $stmt->fetch();
        return isset($row['total']) && (int)$row['total'] > 0;
    }

    // ✅ Insert new vote
    public function insert_vote($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (candidate_id, register_id, position, candidate_name, created_at) 
                VALUES (:candidate_id, :register_id, :position, :candidate_name, NOW())";

        return $this->db->raw($sql, [
            ':candidate_id'   => $data['candidate_id'],
            ':register_id'    => $data['register_id'],
            ':position'       => $data['position'],
            ':candidate_name' => $data['candidate_name']
        ]);
    }

    // ✅ Get already voted positions
    public function get_voted_positions($register_id)
    {
        $sql = "SELECT position FROM {$this->table} WHERE register_id = :register_id";
        $stmt = $this->db->raw($sql, [':register_id' => $register_id]);
        $rows = $stmt->fetchAll();
        return array_column($rows, 'position');
    }



    
public function get_votes_by_voter($register_id)
{
    $sql = "SELECT candidate_name, position, created_at 
            FROM {$this->table} 
            WHERE register_id = :register_id 
            ORDER BY created_at ASC";
    
    $stmt = $this->db->raw($sql, [':register_id' => $register_id]);
    return $stmt->fetchAll();
}

}
