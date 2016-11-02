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

<div id="custom-toolbar">
<!--        <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">-->
<!--            Utwórz projekt-->
<!--        </button>-->
    <?php echo form_open('project') ?>
    <?php echo form_submit('editProject','Edytuj',array('class'=>'btn btn-primary', 'id'=>'editProject','onclick'=>"getToEdit()")); ?>
    <?php echo form_close(); ?>
<!--        <button class="btn btn-primary" id="getToEdit">Edytuj</button>-->
<!--       <button type="submit" class="btn btn-danger"  value="">Usuń</button>-->
<!--    <button type="submit" class="btn btn-success">Wybierz</button>-->
</div>
<div id="custom-bottom">

</div>
<div class="container">
<h2> Moje projekty</h2>
<table id="projectTable" data-toggle="table" data-toolbar="#custom-toolbar"
       data-search="true" data-pagination="true"
       data-height="600" data-show-refresh="true"
       data-click-to-select="true"
       data-single-select="true" >
    <thead>
    <tr>
        <th data-checkbox="true">#</th>
        <th  data-field="name">Nazwa Projektu</th>
        <th>Opis Projektu</th>
        <th>test</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 0 ;
    foreach  ($userProjectData as $value)
    {
        $i++;
        echo '
        <tr>
            <td>'.$i.'</td>
            <td>'.$value['name'].'</td>
            <td>'.$value['description'].'</td>
            <td>'.$value['idProject'].'</td>
        </tr>';
    }?>
    </tbody>
</table>
</div>

<script>
    function getToEdit()
    {
        var value =  JSON.stringify( $('#projectTable').bootstrapTable('getSelections'));
        document.getElementById("editProject").value = value;
    }
</script>






