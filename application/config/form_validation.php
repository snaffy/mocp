<?php
/**
 * Created by PhpStorm.
 * User: azygm
 * Date: 25.10.2016
 * Time: 04:08
 */
$config = array(
    'signup'=> array(
        array(
            'field' => 'login',
            'label' => '',
            'rules' => 'required',
        ),
        array(
            'field' => 'password',
            'label' => '',
            'rules' => 'trim|required|min_length[4]'
        ),
        array(
            'field' => 'passwordconf',
            'label' => '',
            'rules' => 'trim|required|matches[password]'
        )
    )
);

$config['error_prefix'] = '<div class="alert alert-danger" role="alert">';
$config['error_suffix'] = '</div>';