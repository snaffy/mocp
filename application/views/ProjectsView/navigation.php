<div id="top-nav" class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-toggle"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>home">Home</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-user"></i> Admin <span class="caret"></span></a>
                    <ul id="g-account-menu" class="dropdown-menu" role="menu">
                        <li><a href="<?php echo base_url(); ?>profile">Profil</a></li>
                        <li><a href="<?php echo base_url(); ?>logout"><i class="glyphicon glyphicon-lock"></i>
                                Logout</a></li>
                    </ul>
                </li>

            </ul>
            <ul class="nav navbar-nav navbar-left">
                <li><a href="<?php echo base_url(); ?>project">Przegląd</a></li>
                <li><a href="<?php echo base_url(); ?>project/task"">Zadania</a></li>
                <li><a href="#">Dokumenty</a></li>
                <li><a href="#">Rysunki</a></li>
                <li><a href="#">Budżet</a></li>
                <li><a href="#">Zasoby ludzkie</a></li>
            </ul>
        </div>
    </div>
</div>

