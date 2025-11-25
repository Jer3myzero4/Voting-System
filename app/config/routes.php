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
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/


$router->get('/', 'Home::index');
$router->get('/homepage', 'Home::index');


$router->get('/logout', 'Auth::logout');






$router->get('/about', 'Home::about');
$router->get('/contact', 'Home::contact');

$router->get('/admin', 'AdminController::index');





$router->get('/manage-voters', 'AdminController::manage_voters');


$router->get('/election-results', 'ElectionResults::index');
$router->get('/election-results/export_winners_pdf', 'ElectionResults::export_winners_pdf');

$router->get('/election-visualization', 'Election_Visualization::index');


$router->get('/students-dashboard', 'StudentController::student_dashboard');




// Show vote page
$router->get('/vote-now', 'Vote::vote_now');
$router->post('/vote-now', 'Vote::submit_vote');
$router->get('/my-votes', 'Vote::my_votes');





$router->post('manage-candidates', 'CandidateController::create');
$router->get('manage-candidates', 'CandidateController::get_all_candidates');
$router->get('manage-candidates/{:num}', 'CandidateController::get_all_candidates');
$router->post('/manage-candidates/update', 'CandidateController::update');
$router->get('/manage-candidates/delete/{:id}', 'CandidateController::delete');



$router->get('/manage-candidates/search', 'CandidateController::search');

$router->get('/manage-voters', 'AdminController::voters');






$router->match('/register', 'Auth::register', ['POST', 'GET']);
$router->match('/login', 'Auth::login', ['POST', 'GET']);
$router->get('/logout', 'Auth::logout');
$router->get('/confirm_email/{token}', 'Auth::confirm_email');
   
    


$router->get('/leadingcounts', 'ElectionResults::leading');



$router->match('/forgot-password', 'Auth::password_reset', ['POST', 'GET']);
$router->match('/set-new-password', 'Auth::set_new_password', ['POST', 'GET']);



    












