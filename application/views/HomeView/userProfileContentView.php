<div class="container">
    <legend>Mój profil</legend>
    <?php echo form_open('profile'); ?>
    <div class="col-md-5 col-md-offset-2">
        <div class="form-group ">
            <?php
            echo form_error('name');
            echo form_label("Imię: ");
            echo form_input('name', set_value('name'), $attributes = array(
                "class" => "form-control", "id" => "name", "placeholder" => $basicUserData['name'])); ?>
        </div>
        <div class="form-group">
            <?php
            echo form_error('surname');
            echo form_label("Nazwisko: ");
            echo form_input('surname', set_value('surname'), $attributes = array(
                "class" => "form-control", "id" => "surname", "placeholder" => $basicUserData['surname'])); ?>
        </div>
        <div class="form-group">
            <?php
            echo form_error('email');
            echo form_label("E-mail: ");
            echo form_input('email', set_value('email'), $attributes = array(
                "class" => "form-control", "id" => "mail", "placeholder" => $basicUserData['email'])); ?>
        </div>
        <div class="form-group">
            <?php
            echo form_error('phoneNumber');
            echo form_label("Nr telefonu: ");
            echo form_input('phoneNumber', set_value('phoneNumber'), $attributes = array(
                "class" => "form-control", "id" => "phoneNumber", "placeholder" => $basicUserData['phoneNumber'])); ?>
        </div>
        <div class="form-group">
            <?php
            echo form_error('city');
            echo form_label("Miasto: ");
            //            echo form_input('city', set_value('city'), $attributes = array(
            //                "class" => "form-control ", "id" => "city", "placeholder" => "#")); ?>
        </div>
        <div class="form-group">
            <?php
            echo form_error('street');
            echo form_label("Ulica: ");
            //            echo form_input('street', set_value('street'), $attributes = array(
            //                "class" => "form-control", "id" => "street", "placeholder" => "#")); ?>
        </div>
        <div class="form-group text-center">

            <?php echo form_submit('submitBasicData', 'Zatwierdź', array('class' => "btn btn-success btn-md", "id" => "submitBasicData")); ?>
            <?php echo form_reset('reset', 'Anuluj', array('class' => "btn btn-default btn-md", "id" => "reset")); ?>

        </div>

    </div>
    <?php echo form_close() ?>
</div>

<div class="container">
    <legend>Dane logowania</legend>
    <?php echo form_open('profile'); ?>
    <div class="col-md-5 col-md-offset-2">
        <div class="form-group">
            <?php
            echo form_error('login');
            echo form_label("Login: ");
            echo form_input('login', set_value('login'), $attributes = array("class" => "form-control", "id" => "login",
             "placeholder" => $basicUserData['login'])); ?>
        </div>
        <div class="form-group text-center">

            <?php echo form_submit('submitChangeLogin', 'Zatwierdź', array('class' => "btn btn-success btn-md", "id" => "submitLoginData")); ?>
            <?php echo form_reset('reset', 'Anuluj', array('class' => "btn btn-default btn-md ", "id" => "reset")); ?>
        </div>
    <?php echo form_close(); ?>
    </div>
    <?php echo form_open('profile'); ?>
    <div class="col-md-5 col-md-offset-2">
        <div class="form-group">
            <?php
            echo form_error('currentPassword');
            echo form_label("Aktualne hasło: ");
            echo form_password('currentPassword', set_value('currentPassword'), $attributes = array(
                "class" => "form-control", "id" => "currentPassword")); ?>
        </div>
        <div class="form-group">
            <?php echo form_error('password');
            echo form_label("Nowe hasło: ");
            echo form_password('password', set_value('password'), $attributes = array(
                "class" => "form-control", "id" => "password", "placeholder" => "Hasło")); ?>
        </div>
        <div class="form-group">
            <?php echo form_error('passwordconf');
            echo form_label("Powtórz hasło: ");
            echo form_password('passwordconf', set_value('passwordconf'), $attributes = array(
                "class" => "form-control", "id" => "passwordconf", "placeholder" => "Powtórz Hasło")); ?>
        </div>
        <div class="form-group text-center">

            <?php echo form_submit('submitLoginData', 'Zatwierdź', array('class' => "btn btn-success btn-md", "id" => "submitLoginData")); ?>
            <?php echo form_reset('reset', 'Anuluj', array('class' => "btn btn-default btn-md ", "id" => "reset")); ?>

        </div>
        <?php if ($this->session->flashdata('success_msg') != null) echo ' 
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> This alert box could indicate a successful or positive action.
            </div>
            ' ?>

    </div>
    <?php echo form_close(); ?>
</div>


<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Aktualizacja danych.</h4>
                </div>
                <div class="modal-body">
                    <p>Hasło zostało zmienione.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    var m = <?php echo $this->session->flashdata('success_msg') ?>;
    if (m == 'success') {
        $("#myModal").modal();
    }
</script>