<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Candidate_Model extends Model
{
    protected $table = 'candidates';

    
    public function insert_candidate($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

   
    public function count_all()
    {
        return $this->db->table($this->table)->count();
    }


   






    


  public function get_by_fullname($fullname) {
    $result = $this->db->table($this->table)
                       ->where('fullname', $fullname)
                       ->get(); 

    if (is_array($result) && !empty($result)) {
        return reset($result); 
    }

    return null; 
}





























    public function update_candidate($id, $data)
{
    return $this->db->table('candidates')
                    ->where('id', $id)
                    ->update($data);
}






















    public function get_by_id($id)
    {
        $result = $this->db->table($this->table)
                           ->where('id', $id)
                           ->get();

        return !empty($result) ? reset($result) : null;
    }
















    
    public function count_search_results($query)
    {
        $q = addslashes($query);
        $sql = "SELECT COUNT(*) as total FROM {$this->table} 
                WHERE fullname LIKE '%{$q}%' 
                   OR position LIKE '%{$q}%' 
                   OR grade_level LIKE '%{$q}%'";
        $result = $this->db->raw($sql)->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

   
    public function get_paginated($limit_clause)
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id ASC {$limit_clause}";
        return $this->db->raw($sql)->fetchAll(PDO::FETCH_OBJ);
    }

  public function search_candidates($query, $limit_clause)
    {
        $q = addslashes($query);
        $sql = "SELECT * FROM {$this->table} 
                WHERE fullname LIKE '%{$q}%' 
                   OR position LIKE '%{$q}%' 
                   OR grade_level LIKE '%{$q}%' 
                ORDER BY id ASC 
                {$limit_clause}";
        return $this->db->raw($sql)->fetchAll(PDO::FETCH_OBJ);
    }























    public function delete_candidate($id)
{
    return $this->db->table('candidates')
                    ->where('id', $id)
                    ->delete();
}














public function get_all_positions() {
    $sql = "SELECT DISTINCT position FROM candidates ORDER BY position ASC";
    $stmt = $this->db->raw($sql);
    $rows = $stmt->fetchAll();
    return array_column($rows, 'position');
}



public function get_candidate_by_id($id)
{
    return $this->db->table('candidates')->where('id', $id)->get();
}




  public function get_all_candidates_grouped_by_position()
    {
        $candidates = $this->db->table($this->table)->get_all();
        $grouped = [];

        foreach ($candidates as $row) {
            $grouped[$row['position']][] = $row;
        }

        return $grouped;
    }

}
