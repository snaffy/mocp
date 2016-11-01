<div class="container">
    <h2> Moje projekty</h2>
    <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
        Utwórz projekt
    </button>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Utwórz nowy projekt </h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('home', array('class' => 'form-horizontal')); ?>
                <div class="form-group">
                    <div class="col-md-6">
                        <?php echo form_input('projectName', '', array('class' => 'form-control', 'id' => 'projectName',
                            'placeholder' => 'Nazwa projektu')) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <?php echo form_textarea('projectDescription', '', array('class' => "form-control", 'id' => "projectDescription",
                            'rows' => '3', 'placeholder' => 'Opis projektu')) ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php echo form_submit('createProject','Utwórz',array('class'=>'btn btn-primary')) ?>
                <?php echo form_submit('createProject','Anuluj',array('class'=>'btn btn-default', 'data-dismiss'=>'modal')) ?>


            </div>
            <?php echo form_close(); ?>

        </div>
    </div>
</div>

<table class="table">
    <thead class="thead-inverse">
    <tr>
        <th>#</th>
        <th>Nazwa Projektu</th>
        <th>Opis Projektu</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $i = 0 ;
        foreach  ($userProject as $value)
        {
            $i++;
            echo '<tr>
            <th scope="row">'.$i.'</th>
            <td>'.$value['name'].'</td>
            <td>'.$value['description'].'</td>
        </tr>';
        }?>

    </tbody>
</table>

