<?php
/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 28.10.2016
 * Time: 01:48
 */
class MY_Form_validation extends CI_Form_validation
{
    function __construct($config = array())
    {
        parent::__construct($config);
    }

    function noNumeric($str)
    {

    }
}