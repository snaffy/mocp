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

    function checkPassword($hasshedPasswrd)
    {
        
        var_dump($hasshedPasswrd);
//        var_dump($password);
//        return password_verify($password,$hasshedPasswrd);
        $this->set_message('checkPassword',"MSG");
        return false;
    }
} 