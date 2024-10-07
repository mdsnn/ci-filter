<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();

        
        $this->load->model('crud_model');
    }

    // 27/9/24 MS: Default method for the welcome page.

    public function index()
    {
        // 27/9/24 MS: Retrieve all posts and the list of years from the model

        $posts = $this->crud_model->get_entries(); 
        $years = $this->crud_model->getYears(); 

        // 27/9/24 MS: Load the welcome view and pass the retrieved posts and years data

        $this->load->view('welcome_message', ['posts' => $posts, 'years' => $years]);
    }

    // 27/9/24 MS: Method to display posts filtered by a specific year

    public function posts($year)
    {
        // 27/9/24 MS: Retrieve posts corresponding to the specified year

        $posts = $this->crud_model->getYear($year);
        $years = $this->crud_model->getYears();

        // 27/9/24 MS: Load the posts view and pass the retrieved posts, years, and selected year

        $this->load->view('posts', ['posts' => $posts, 'years' => $years, 'year' => $year]);
    }
}
