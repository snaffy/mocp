<body>

<nav class="navbar navbar-dark bg-primary">
    <h1>MOCP</h1>
</nav>

<div class="row">
    <div class="container col-md-offset-4">
        <div class="col-md-4">
            <h1>Witaj ponownie!</h1>
            <p class="lead">Zaloguj się by mieć dostęp do sowich projektów.</p>
            <?php echo form_open('login'); ?>
            <div class="form-group">
                <?php echo form_input('login', set_value('login'), $attributes = array(
                    "class" => "form-control", "id" => "login", "placeholder" => "Login")); ?>
            </div>
            <div class="form-group">
                <?php echo form_password('password', set_value('password'), $attributes = array(
                    "class" => "form-control", "id" => "password", "placeholder" => "Hasło")); ?>
            </div>
            <div class="form-group">
                <?php echo form_checkbox('remember', set_value('remember'), FALSE); ?> Zapamiętaj mnie
            </div>
            <div class="form-group">
                <?php echo form_submit('submit', 'loginSubmit', array('class' => "btn-primary btn-block", "id" => "submit")); ?>
            </div>

            <?php echo form_close() ?>
            <p>Nie masz konta? <a href="<?php echo base_url(); ?>register">Rejestracja</a></p>
        </div>
    </div>
</body>