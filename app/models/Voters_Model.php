<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Voters_Model extends Model
{
    protected $table = 'register';
    
    
    // your table name

    // ✅ Get all voters (role = student)
    public function get_all_voters()
    {
        return $this->db
            ->table($this->table)
            ->where('role', 'student')
            ->get_all();
    }

    // Optional: get voter by ID
    public function get_voter($id)
    {
        return $this->db
            ->table($this->table)
            ->where('id', $id)
            ->get();
    }


  public function count_voters()
{
    // Run a raw SQL query
    $result = $this->db->raw("SELECT COUNT(*) AS total FROM register WHERE role = 'student'");

    // Fetch the first row as an associative array
    $row = $result->fetch();

    // Return the count safely
    return isset($row['total']) ? (int)$row['total'] : 0;
}


public function count_candidates()
{
    // Run a raw SQL query to count all rows in the candidates table
    $result = $this->db->raw("SELECT COUNT(*) AS total FROM candidates");

    // Fetch the first row as an associative array
    $row = $result->fetch();

    // Return the count safely
    return isset($row['total']) ? (int)$row['total'] : 0;
}


public function count_president_candidates()
{
    // Run a raw SQL query
    $result = $this->db->raw("SELECT COUNT(*) AS total FROM candidates WHERE position = 'president'");

    // Fetch the first row as an associative array
    $row = $result->fetch();

    // Return the count safely
    return isset($row['total']) ? (int)$row['total'] : 0;
}


public function count_vicepresident_candidates()
{
    // Run a raw SQL query
    $result = $this->db->raw("SELECT COUNT(*) AS total FROM candidates WHERE position = 'vice president'");

    // Fetch the first row as an associative array
    $row = $result->fetch();

    // Return the count safely
    return isset($row['total']) ? (int)$row['total'] : 0;
}

public function count_secretary_candidates()
{
    // Run a raw SQL query
    $result = $this->db->raw("SELECT COUNT(*) AS total FROM candidates WHERE position = 'secretary'");

    // Fetch the first row as an associative array
    $row = $result->fetch();

    // Return the count safely
    return isset($row['total']) ? (int)$row['total'] : 0;
}

public function count_treasurer_candidates()
{
    // Run a raw SQL query
    $result = $this->db->raw("SELECT COUNT(*) AS total FROM candidates WHERE position = 'treasurer'");

    // Fetch the first row as an associative array
    $row = $result->fetch();

    // Return the count safely
    return isset($row['total']) ? (int)$row['total'] : 0;
}

public function count_auditor_candidates()
{
    // Run a raw SQL query
    $result = $this->db->raw("SELECT COUNT(*) AS total FROM candidates WHERE position = 'auditor'");

    // Fetch the first row as an associative array
    $row = $result->fetch();

    // Return the count safely
    return isset($row['total']) ? (int)$row['total'] : 0;
}


public function count_pio_candidates()
{
    // Run a raw SQL query
    $result = $this->db->raw("SELECT COUNT(*) AS total FROM candidates WHERE position = 'pio'");

    // Fetch the first row as an associative array
    $row = $result->fetch();

    // Return the count safely
    return isset($row['total']) ? (int)$row['total'] : 0;
}

public function count_businessmanager_candidates()
{
    // Run a raw SQL query
    $result = $this->db->raw("SELECT COUNT(*) AS total FROM candidates WHERE position = 'business manager'");

    // Fetch the first row as an associative array
    $row = $result->fetch();

    // Return the count safely
    return isset($row['total']) ? (int)$row['total'] : 0;
}

public function count_muse_candidates()
{
    // Run a raw SQL query
    $result = $this->db->raw("SELECT COUNT(*) AS total FROM candidates WHERE position = 'muse'");

    // Fetch the first row as an associative array
    $row = $result->fetch();

    // Return the count safely
    return isset($row['total']) ? (int)$row['total'] : 0;
}


public function count_escort_candidates()
{
    // Run a raw SQL query
    $result = $this->db->raw("SELECT COUNT(*) AS total FROM candidates WHERE position = 'escort'");

    // Fetch the first row as an associative array
    $row = $result->fetch();

    // Return the count safely
    return isset($row['total']) ? (int)$row['total'] : 0;
}

public function submit_vote()
{
    $voter_id = $_SESSION['user_id'];
    $candidate_id = $_POST['candidate_id'];

    // 1️⃣ Insert the vote record
    $this->db->table('votes')->insert([
        'register_id' => $voter_id,
        'candidate_id' => $candidate_id
    ]);

    // 2️⃣ Update has_voted status in register table
    $this->db->table('register')
        ->where('id', $voter_id)
        ->update(['has_voted' => 1]);

    // 3️⃣ Redirect or show confirmation
    redirect('/thankyou');
}


public function count_pending_votes()
{
    $sql = "SELECT COUNT(*) AS total_pending
            FROM register r
            WHERE r.role = 'student'
            AND r.id NOT IN (
                SELECT DISTINCT v.register_id 
                FROM votes v
            )";

    $stmt = $this->db->raw($sql);
    $result = $stmt->fetch();

    return $result ? $result['total_pending'] : 0;
}





















public function search_voters($keyword)
{
    $keyword = trim($keyword);

    return $this->db
        ->table('register')
        ->where("LOWER(fullname) LIKE LOWER('%{$keyword}%') 
                 OR LOWER(email) LIKE LOWER('%{$keyword}%') 
                 OR CAST(id AS CHAR) LIKE '%{$keyword}%'")
        ->get_all();
}









 


   
   
}
