<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Db_log {
    var $CI;
    function __construct() {
        $this->CI = & get_instance(); // Create instance of CI
    }

    function log_queries() {
        $filepath = APPPATH . 'mysqllogs/Query-Log-' . date('Y-m-d') . '.php'; // Filepath. File is created in logs folder with name QueryLog
        $handle = fopen($filepath, "a+"); // Open the file
        $times = $this->CI->db->query_times; // We get the array of execution time of each query that got executed by our application(controller)
        foreach ($this->CI->db->queries as $key => $query) { // Loop over all the queries  that are stored in db->queries array
            $sql = $query; //. " \n Execution Time:" . $times[$key]; // Write it along with the execution time
            fwrite($handle, $sql . "\n\n");
        }
        fclose($handle); // Close the file
    }
}