<?php

class Crud_model extends CI_Model
{
    // 27/9/24 MS: Method to retrieve all student entries from the database
    public function get_entries()
    {
        // 27/9/24 MS: Perform a database query to get all records from the 'student' table
        $query = $this->db->get('student');
        return $query->result();
    }

    // 27/9/24 MS: Method to retrieve distinct years from the 'created_at' field in the student table
    
    public function getYears()
    {
        
        $this->db->distinct();
        $this->db->select('YEAR(`created_at`) AS year');
        $this->db->from('student');

        $this->db->order_by('YEAR(`created_at`)', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // 27/9/24 MS: Method to retrieve student entries for a specific year

    public function getYear($year)
    {
        
        $this->db->select('id, name, standard, percentage, result, created_at');
        $this->db->from('student');
        $this->db->where('YEAR(created_at)', $year);
        $query = $this->db->get();
        return $query->result();
    }
}
