<?php
/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 07.11.2016
 * Time: 06:04
 */
class MY_Input extends CI_Input {
    function _sanitize_globals()
    {
        $this->allow_get_array = TRUE;
        parent::_sanitize_globals();
    }
}