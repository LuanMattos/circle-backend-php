<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Array Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/helpers/array_helper.html
 */

// ------------------------------------------------------------------------





if ( ! function_exists('validate_telcel_br'))
{

	function validate_telcel_br($tel)
	{
        $search = ["(",")",".","-"," ","X","*","!","@","'","´",",","+"];

        $numer  = str_replace($search,"",$tel);

        if(strlen($numer) != 13){
            return false;
        }
        return $numer;
	}
}


