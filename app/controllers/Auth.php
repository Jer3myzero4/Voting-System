<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

require_once ROOT_DIR . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Auth extends Controller
{

   

 

   

     public function index() {
        $this->call->view('auth/login');
    }  


     public function register()
{
    if ($this->form_validation->submitted()) {

        
        $fullname = $this->io->post('fullname');
        $email = $this->io->post('email');
        $password = $this->io->post('password');
        $confirm_password = $this->io->post('confirm_password');
        $grade = $this->io->post('grade');
        $section = $this->io->post('section');
        $role = $this->io->post('role');
        $email_token = bin2hex(random_bytes(50));

       
        $this->form_validation
            ->name('fullname')->required()
            ->name('email')->required()->is_unique('register', 'email', $email, 'Email is already registered.')
            ->name('password')->required()
            ->name('confirm_password')->required()->matches('password', 'Passwords did not match.')
            ->name('grade')->required()
            ->name('section')->required()
            ->name('role')->required();

        if ($this->form_validation->run()) {
       
            $user_id = $this->lauth->register($fullname, $email, $password, $grade, $section, $role, $email_token);
            if ($user_id) {
             
                $this->send_confirmation_email($email, $email_token);

                $this->session->set_flashdata('notification', json_encode([
                    'icon' => 'success',
                    'title' => 'Registration Successful',
                    'text' => 'Your account has been created! Please check your email to confirm your account.'
                ]));

                redirect('/register');
            } else {
           
                $this->session->set_flashdata('notification', json_encode([
                    'icon' => 'error',
                    'title' => 'Registration Failed',
                    'text' => config_item('SQLError')
                ]));
                redirect('/register');
            }
        } else {
           
            $this->session->set_flashdata('notification', json_encode([
                'icon' => 'error',
                'title' => 'Validation Error',
                'text' => $this->form_validation->errors() 
            ]));
            redirect('/register');
        }

    } else {

        $flash = [
            'notification' => $this->session->flashdata('notification') ?? null
        ];
        $this->call->view('auth/register', $flash);
    }
}












   
private function send_confirmation_email($email, $token)
{
    $mail = new PHPMailer(true);
    try {
        // Enable verbose debug output (remove in production)
        $mail->SMTPDebug = 0; // Set 2 for debug
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';       // Gmail SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bsitjeremyfestin@gmail.com'; // Your Gmail
        $mail->Password   = 'mlfmsmkkuppbcjgf';           // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS encryption
        $mail->Port       = 587;                         // TLS port

        // Sender & Recipient
        $mail->setFrom('bsitjeremyfestin@gmail.com', 'Voting System Admin');
        $mail->addAddress($email);

        // Email format
        $mail->isHTML(true);
        $mail->Subject = 'Confirm Your Email Address';

        $base = rtrim(base_url(), '/'); 
        $confirm_url = $base . '/confirm_email/' . urlencode($token);

        $mail->Body = "
            <h2>Welcome to Voting System for High School Student Officer Elections!</h2>
            <p>Click the button below to confirm your email:</p>
            <a href='$confirm_url' style='background-color:#28a745;color:#fff;padding:10px 20px;text-decoration:none;border-radius:5px;'>Confirm Email</a>
            <p>If the button doesn’t work, copy this link into your browser:</p>
            <p>$confirm_url</p>
            <br>
            <p>Thank you,<br>Voting System Admin</p>
        ";

        // Send email
        $mail->send();
        error_log("✅ Confirmation email sent to: $email");
        return true;

    } catch (Exception $e) {
        error_log("❌ Email could not be sent. PHPMailer Error: {$mail->ErrorInfo}");
        return false;
    }
}











    public function confirm_email($token)
{
    error_log("Confirm Email Token: " . $token);

    $user = $this->lauth->activate_account($token);

    if ($user) {
        set_flash_alert('success', 'Your email has been confirmed. You can now log in.');
        redirect('/login');
    } else {
        set_flash_alert('danger', 'Invalid or expired token.');
        redirect('/login');
    }
}

 
    

    public function activate_account($token) {
        $user = $this->db->where('email_token', $token)->get('register')->row();
    
        if ($user && !$user->is_active) {
            $this->db->set('is_active', 1)
                     ->set('is_verified', 1)  
                     ->set('email_token', null) 
                     ->where('id', $user->id)
                     ->update('register');
    
            return $user;
        }
        return false;
    }
    




















   public function login()
{
    if ($this->form_validation->submitted()) {
        $email = $this->io->post('email');
        $password = $this->io->post('password');
        $selected_role = $this->io->post('role');

        $user = $this->lauth->get_user_by_email($email);

        if (!$user) {
            $this->session->set_flashdata('notification', json_encode([
                'icon' => 'error',
                'title' => 'Login Failed',
                'text' => 'Email not found.'
            ]));
            redirect('/login');
            return;
        }

        if (!password_verify($password, $user['password'])) {
            $this->session->set_flashdata('notification', json_encode([
                'icon' => 'error',
                'title' => 'Login Failed',
                'text' => 'Incorrect password.'
            ]));
            redirect('/login');
            return;
        }

        // 🔒 Role Check
        if ($user['role'] !== $selected_role) {
            $this->session->set_flashdata('notification', json_encode([
                'icon' => 'error',
                'title' => 'Access Denied',
                'text' => 'The role you selected does not match your account.'
            ]));
            redirect('/login');
            return;
        }

        // ✅ Continue login if all checks pass
        if ($user['is_active'] != 1) {
            $this->session->set_flashdata('notification', json_encode([
                'icon' => 'warning',
                'title' => 'Account Not Activated',
                'text' => 'Please verify your email before logging in.'
            ]));
            redirect('/login');
            return;
        }

        $this->lauth->set_logged_in($user['id']);
        $this->session->set_userdata([
            'fullname' => $user['fullname'],
            'email' => $user['email'],
            'role' => $user['role']
        ]);

        $this->session->set_flashdata('notification', json_encode([
            'icon' => 'success',
            'title' => 'Login Successful',
            'text' => 'Welcome back, ' . $user['fullname'] . '!'
        ]));

        // Redirect based on role
        if ($user['role'] === 'student') {
            redirect('/students-dashboard');
        } elseif ($user['role'] === 'admin') {
            redirect('/admin');
        } else {
            redirect('/login');
        }
    } else {
        $flash = [
            'notification' => $this->session->flashdata('notification') ?? null
        ];
        $this->call->view('auth/login', $flash);
    }
}






















































private function send_password_token_to_email($email, $token) {
    
    $template_path = ROOT_DIR . '/public/templates/reset_password_email.html';
    if (!file_exists($template_path)) {
        error_log("Reset password template not found: {$template_path}");
        return false;
    }

    $template = file_get_contents($template_path);

   
    $base = rtrim(base_url(), '/');

  
    $template = str_replace(['{token}', '{base_url}'], [$token, $base], $template);

  
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bsitjeremyfestin@gmail.com'; 
        $mail->Password   = 'mlfmsmkkuppbcjgf';   // Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('bsitjeremyfestin@gmail.com', 'Voting System');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Voting System Reset Password';
        $mail->Body    = $template;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
public function password_reset() {
    if ($this->form_validation->submitted()) {
        $email = $this->io->post('email');
        $this->form_validation->name('email')->required()->valid_email();

        if ($this->form_validation->run()) {
            $token = $this->lauth->reset_password($email);

            if ($token && $this->send_password_token_to_email($email, $token)) {
               
                $this->session->set_flashdata('notification', json_encode([
                    'icon' => 'success',
                    'title' => 'Reset Email Sent!',
                    'text' => 'A password reset link has been sent to your email.'
                ]));
            } else {
             
                $this->session->set_flashdata('notification', json_encode([
                    'icon' => 'error',
                    'title' => 'Reset Failed',
                    'text' => 'We could not send the reset link. Please try again.'
                ]));
            }
            redirect('/forgot-password');
        } else {
         
            $this->session->set_flashdata('notification', json_encode([
                'icon' => 'error',
                'title' => 'Invalid Email',
                'text' => $this->form_validation->errors()
            ]));
            redirect('/forgot-password');
        }
    } else {
        $flash = [
            'notification' => $this->session->flashdata('notification') ?? null
        ];
        $this->call->view('auth/forgot_password', $flash);
    }
}
public function set_new_password() {
    $token = $_GET['token'] ?? '';

    if (empty($token)) {
        $this->session->set_flashdata('notification', json_encode([
            'icon' => 'error',
            'title' => 'Invalid Request',
            'text' => 'Missing password reset token.'
        ]));
        redirect('/forgot-password');
        return;
    }

    $token_row = $this->lauth->get_reset_password_token($token);
    if (!$token_row) {
        $this->session->set_flashdata('notification', json_encode([
            'icon' => 'error',
            'title' => 'Invalid Token',
            'text' => 'The password reset link is invalid or expired.'
        ]));
        redirect('/forgot-password');
        return;
    }

    if ($this->form_validation->submitted()) {
        $password = $this->io->post('password');
        $confirm_password = $this->io->post('confirm_password');

        $this->form_validation
            ->name('password')->required()->min_length(8, 'Password must be at least 8 characters.')
            ->name('confirm_password')->required()->matches('password', 'Passwords do not match.');

        if ($this->form_validation->run()) {
            $reset_success = $this->lauth->reset_password_now($token, $password);

            if ($reset_success) {
                $this->session->set_flashdata('notification', json_encode([
                    'icon' => 'success',
                    'title' => 'Password Updated!',
                    'text' => 'You can now log in with your new password.'
                ]));
                redirect('/login');
                return;
            } else {
                $this->session->set_flashdata('notification', json_encode([
                    'icon' => 'error',
                    'title' => 'Update Failed',
                    'text' => 'Something went wrong. Please try again.'
                ]));
                redirect('/set-new-password?token=' . urlencode($token));
                return;
            }
        } else {
            $this->session->set_flashdata('notification', json_encode([
                'icon' => 'error',
                'title' => 'Validation Error',
                'text' => $this->form_validation->errors()
            ]));
            redirect('/set-new-password?token=' . urlencode($token));
            return;
        }
    }

    $flash = [
        'notification' => $this->session->flashdata('notification') ?? null,
        'token' => $token
    ];

    $this->call->view('auth/set_new_password', $flash);
}















  public function logout()
    {
        // Start session only if it's not started yet
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Destroy all session data
        session_unset();
        session_destroy();

        // Redirect to landing page
        redirect('/homepage');
    }






    protected function protect_page($role = null)
{
    // 1. Check if user is logged in
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        redirect('/login'); // redirect to login if not logged in
        exit;
    }

    // 2. Optional: Check role (admin/student)
    if ($role && isset($_SESSION['role']) && $_SESSION['role'] !== $role) {
        // Redirect user to their proper dashboard
        if ($_SESSION['role'] === 'admin') {
            redirect('/admin');
        } else {
            redirect('/students-dashboard');
        }
        exit;
    }
}











    
}
