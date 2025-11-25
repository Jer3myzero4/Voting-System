<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 * 
 * Copyright (c) 2020 Ronald M. Marasigan
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @copyright Copyright 2020 (https://ronmarasigan.github.io)
 * @since Version 1
 * @link https://lavalust.pinoywap.org
 * @license https://opensource.org/licenses/MIT MIT License
 */

 /**
  * Auth Class
  * This will be remove in version 2.5
  * It can still be used then as independent library
  */
class Lauth {

	private $LAVA;

	public function __construct() {
		$this->LAVA =& lava_instance();
		$this->LAVA->call->database();
		$this->LAVA->call->library('session');

		$adminExists = $this->LAVA->db
        ->table('register')
        ->where('email', 'admin@votingsystem.com')
        ->get();

		  // If admin doesn't exist, create it
    if (empty($adminExists)) {
        $this->LAVA->db->table('register')->insert([
            'fullname'    => 'Administrator',
            'email'       => 'admin@votingsystem.com',
            'password'    => $this->passwordhash('admin123'),
            'role'        => 'admin',
            'is_active'   => 1,
            'is_verified' => 1
        ]);
    }

	}

	/**
	 * Password Default Hash
	 * @param  string $password User Password
	 * @return string  Hashed Password
	 */


	


	
	public function passwordhash($password)
	{
		$options = array(
		'cost' => 4,
		);
		return password_hash($password, PASSWORD_BCRYPT, $options);
	}

	/**
	 * [register description]
	 * @param  string $fullname  fullname
	 * @param  string $password  Password
	 * @param  string $email     Email
	 * @param  string $usertype   Usertype
	 * @return $this
	 */

	 public function activate_account($token): ?int
	 {
		 $this->LAVA->db->transaction();
	 
		 $user = $this->LAVA->db
			 ->table('register')
			 ->where('email_token', $token)
			 ->get();
	 
		 if ($user && isset($user['id']) && !$user['is_active']) {
			 $this->LAVA->db
				 ->table('register')
				 ->where('id', $user['id'])
				 ->update(['is_active' => 1, 'is_verified' => 1, 'email_token' => null]);
	 
			 $this->LAVA->db->commit();
			 return $user['id'];
		 } else {
			 $this->LAVA->db->roll_back();
			 return null; // or false
		 }
	 }
	 
	public function register($fullname, $email, $password, $grade, $section, $role, $email_token)
{
    // Start transaction
    $this->LAVA->db->transaction();

    // Prepare user data
    $data = array(
        'fullname'     => $fullname,
        'email'        => $email,
        'password'     => $this->passwordhash($password), // Encrypt password
        'grade'        => $grade,
        'section'      => $section,
        'role'         => $role,
        'email_token'  => $email_token,
        'is_verified'  => 0, // Default unverified until email confirmation
    );

    // Insert to database
    $res = $this->LAVA->db->table('register')->insert($data);

    // If successful, commit transaction
    if ($res) {
        $this->LAVA->db->commit();
        return $this->LAVA->db->last_id();
    } 
    else {
        $this->LAVA->db->roll_back();
        return false;
    }
}


	/**
	 * Login
	 * @param  string $fullname Fullname
	 * @param  string $password Password
	 * @return string Validated Fullnamme
	 */
	public function login($email, $password): ?int 
{
   
    $row = $this->LAVA->db
        ->table('register')                     
        ->where('email', $email)
        ->get();

   
    if ($row) {
     
        if (password_verify($password, $row['password'])) {
            
            if ($row['is_active'] == 1) {
                return $row['id']; 
            } else {
                return false; 
            }
        } else {
            return false; 
        }
    }

    return false;
}


	/**
	 * Change Password
	 *
	 * @param string $password
	 * @return void
	 */
	public function change_password($password) {
		$data = array(
					'password' => $this->passwordhash($password)
				);
		return  $this->LAVA->db
					->table('register')
					->where('register_id', $this->get_register_id())
					->update($data);
	}

	/**
	 * Set up session for login
	 * @param $this
	 */



	public function set_logged_in($register_id) {
		$session_data = hash('sha256', md5(time().$this->get_register_id()));
		$data = array(
			'register_id' => $register_id,
			'browser' => $_SERVER['HTTP_USER_AGENT'],
			'ip' => $_SERVER['REMOTE_ADDR'],
			'session_data' => $session_data
		);
		$res = $this->LAVA->db->table('sessions')
				->insert($data);
		if($res) $this->LAVA->session->set_userdata(array('session_data' => $session_data, 'register_id' => $register_id, 'logged_in' => 1));
	}


	// Lauth.php
public function protect_page()
{
    // Check if user is logged in
    if (!$this->is_logged_in()) {
        redirect('/login'); // kung hindi logged in, punta sa login page
        exit;
    }
}




	

	/**
	 * Check if user is Logged in
	 * @return bool TRUE is logged in
	 */
	public function is_logged_in(): bool 
{
    $data = array(
        'register_id' => $this->LAVA->session->userdata('register_id'),
        'browser' => $_SERVER['HTTP_USER_AGENT'],
        'session_data' => $this->LAVA->session->userdata('session_data')
    );
    
    $count = $this->LAVA->db->table('sessions')
        ->select_count('session_id', 'count')
        ->where($data)
        ->get()['count'];

    if ($this->LAVA->session->userdata('logged_in') == 1 && $count > 0) {
        return true;
    } else {
        if ($this->LAVA->session->has_userdata('register_id')) {
            $this->set_logged_out();
        }
    }

    return false; // Ensure to return false if not logged in
}

	/**
	 * Get User ID
	 * @return string User ID from Session
	 */
	public function get_register_id()
	{
		$register_id = $this->LAVA->session->userdata('register_id');
		return !empty($register_id) ? (int) $register_id : 0;
	}

	/**
	 * Get Username
	 * @return string fullname from Session
	 */
	public function get_fullname($register_id): ?string // Allowing null return
{
    $row = $this->LAVA->db
        ->table('register')
        ->select('fullname')                    
        ->where('id', $register_id)
        ->limit(1)
        ->get();

    if ($row) {
        return html_escape($row['fullname']);
    }

    return null; 
}


	public function set_logged_out() {
		$data = array(
			'register_id' => $this->get_register_id(),
			'browser' => $_SERVER['HTTP_USER_AGENT'],
			'session_data' => $this->LAVA->session->userdata('session_data')
		);
		$res = $this->LAVA->db->table('sessions')
						->where($data)
						->delete();
		if($res) {
			$this->LAVA->session->unset_userdata(array('register_id'));
			$this->LAVA->session->sess_destroy();
			return true;
		} else {
			return false;
		}
		
	}

	public function verify($token) {
		return $this->LAVA->db
						->table('register')
						->select('id')
						->where('email_token', $token)
						->where_null('email_verified_at')
						->get();	
	}

	public function verify_now($token) {
		return $this->LAVA->db
						->table('register')
						->where('email_token' ,$token)
						->update(array('email_verified_at' => date("Y-m-d h:i:s", time())));	

	}
	
	public function send_verification_email($email) {
		return $this->LAVA->db
						->table('register')
						->select('fullname, email_token')
						->where('email', $email)
						->where_null('email_verified_at')
						->get();	
	}
	
	public function reset_password($email) {
		$row = $this->LAVA->db
						->table('register')
						->where('email', $email)
						->get();
		if($this->LAVA->db->row_count() > 0) {
			$this->LAVA->call->helper('string');
			$data = array(
				'email' => $email,
				'reset_token' => random_string('alnum', 10)
			);
			$this->LAVA->db
				->table('password_reset')
				->insert($data)
				;
			return $data['reset_token'];
		} else {
			return FALSE;
		}
	}

	public function is_user_verified($email) {
		$this->LAVA->db
				->table('register')
				->where('email', $email)
				->where_not_null('email_verified_at')
				->get();
	return $this->LAVA->db->row_count();
	}











public function get_reset_password_token($token) {
    // ✅ Ensure token is provided
    if (empty($token)) {
        error_log("⚠️ Missing reset token in get_reset_password_token()");
        return false;
    }

    // ✅ Fetch token from password_reset table
    $result = $this->LAVA->db->table('password_reset')
        ->where('reset_token', $token)
        ->get();

    // ✅ If query failed or returned no result
    if (!$result || !is_array($result) || count($result) === 0) {
        error_log("⚠️ No matching token found or query failed for token: $token");
        return false;
    }

    // ✅ If get() already returns a single row array
    // Check token expiration field
    $row = is_array($result) && isset($result[0]) ? $result[0] : $result;

    if (isset($row['token_expiration']) && strtotime($row['token_expiration']) < time()) {
        error_log("⚠️ Token expired for email: {$row['email']}");
        return false;
    }

    return $row;
}



	public function reset_password_now($token, $new_password) {
    $token_row = $this->get_reset_password_token($token);
    if (!$token_row) return false;

    $email = $token_row['email'];
    $hashed_password = $this->passwordhash($new_password);

    // Update password in register table
    $this->LAVA->db->table('register')
        ->where('email', $email)
        ->update(['password' => $hashed_password]);

    // Delete token entry from reset_password table
    $this->LAVA->db->table('password_reset')
        ->where('reset_token', $token)
        ->delete();

    return true;
}





	public function get_user_by_email($email)
{
    $user = $this->LAVA->db
        ->table('register')
        ->where('email', $email)
        ->get(); // Returns row as array or false

    return $user ?: false;
}


}

?>