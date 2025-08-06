<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Customlib {
	
	private $CI;
	function __construct() {
		$this->CI = get_instance();
	}

	public function base64_image_upload($image_data='',$path='')
	{
	    $image_parts = explode(";base64,", $image_data);
	    $image_type_aux = explode("image/", $image_parts[0]);
	    $image_type = $image_type_aux[1];
	    $image_base64 = base64_decode($image_parts[1]);
	    $image_name = uniqid().'.'.$image_type;
	    $file = $path.'/'.$image_name;
	    file_put_contents($file, $image_base64);
	    return $image_name;
	}

	function addDaysToDate($date, $day)
    {
        return date('Y-m-d', strtotime($date. ' + '.$day.' day'));
    }

    function addMonthsToDate($date, $month)
    {
        return date('Y-m-d', strtotime($date. ' + '.$month.' months'));
    }

    function addYearsToDate($date, $year)
    {
        return date('Y-m-d', strtotime($date. ' + '.$year.' years'));
    }

    function minusDaysToDate($date, $day)
    {
        return date('Y-m-d', strtotime($date. ' - '.$day.' day'));
    }
}
// EOF