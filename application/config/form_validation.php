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
    ),
    'basicField'=>array(
//        array(
//            'field' => 'name',
//            'label' => 'Imię',
//            'rules' => 'alpha',
//        ),
        array(
            'field' => 'surname',
            'label' => 'Nazwisko',
            'rules' => 'alpha',
        ),
        array(
            'field' => 'email',
            'label' => 'E-mail',
            'rules' => 'valid_email',
        ),
        array(
            'field' => 'phoneNumber',
            'label' => 'Nr telefonu',
            'rules' => 'integer|max_length[11]|min_length[9]',
        ),
        array(
            'field' => 'city',
            'label' => 'Miasto',
            'rules' => 'max_length[45]',
        ),
        array(
            'field' => 'street',
            'label' => 'Ulica',
            'rules' => 'max_length[45]',
        )
    )
);


$config['error_prefix'] = '<div class="alert alert-danger" role="alert">';
$config['error_suffix'] = '</div>';