<body>
<h2><?php echo $title; ?></h2>


<?php echo form_open('register'); ?>

<div class="row">
    <div class="container">
        <div class="col-md-4">

            <div class="form-group">
                <?php echo form_error('login');
                echo form_input('login',set_value('login'), $attributes=array(
                    "class"=> "form-control","id"=>"login", "placeholder"=>"Login")); ?>
            </div>
            <div class="form-group">
                <?php echo form_error('password');
                echo form_password('password',set_value('password'), $attributes=array(
                    "class"=> "form-control","id"=>"password", "placeholder"=>"Hasło")); ?>
            </div>
            <div class="form-group">
                <?php echo form_error('passwordconf');
                echo form_password('passwordconf',set_value('passwordconf'), $attributes=array(
                    "class"=> "form-control","id"=>"passwordconf", "placeholder"=>"Powtórz Hasło")); ?>
            </div>
            <div class="form-group">
               <?php echo form_submit('submit','Submit',array('class'=>"btn-primary btn-block","id"=>"submit"));?>
            </div>

        </div>

    </div>
</div>
<?php echo form_close()?>

</body>