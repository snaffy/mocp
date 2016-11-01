<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/styles.css'); ?>" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>

    <link rel="stylesheet" href="<?php echo base_url('node_modules/bootstrap_table/src/bootstrap-table.css'); ?>">
    <script src="<?php echo base_url('node_modules/bootstrap_table/src/bootstrap-table.js'); ?>"></script>
    <script src="<?php echo base_url('node_modules/bootstrap_table/src/locale/bootstrap-table-pl-PL.js'); ?>"></script>


</head>
<body>
<!-- Header -->
<div id="top-nav" class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-toggle"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>home">Control Panel</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-user"></i> Admin <span class="caret"></span></a>
                    <ul id="g-account-menu" class="dropdown-menu" role="menu">
                        <li><a href="<?php echo base_url(); ?>profile">Profil</a></li>
                        <li><a href="<?php echo base_url(); ?>logout"><i class="glyphicon glyphicon-lock"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /container -->
</div>
<!-- /Header -->

<!-- script references -->

