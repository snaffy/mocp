<div id="custom-toolbar">
    <div class="form-group">
        <?php echo form_open('project', array('id' => 'formSubmit')) ?>
        <?php echo form_button('createProject', 'Utwórz projekt', array('class' => 'btn btn-primary btn-lg', 'id' => 'createProject', 'onclick' => "startModal()")); ?>
        <?php echo form_button('getToEdit', 'Edytuj', array('class' => 'btn btn-primary', 'id' => 'getToEdit', 'onclick' => "getToEdit()")); ?>
        <?php echo form_button('deleteProject', 'Usuń projekt', array('class' => 'btn btn-danger', 'id' => 'deleteProject')); ?>
        <?php echo form_input('setProject', 'Wybierz', array('class' => 'btn btn-success', 'id' => 'setProject', 'onclick' => "getProject()",'type'=>'button')); ?>
        <?php echo form_close(); ?>

    </div>
</div>


<div class="container">
    <h2> Moje projekty</h2>
    <table id="projectTable" data-toggle="table" data-toolbar="#custom-toolbar"
           data-search="true" data-pagination="true"
           data-height="600" data-show-refresh="true"
           data-click-to-select="true"
           data-single-select="true">
        <thead>
        <tr>
            <th data-checkbox="true" data-field="idProject" data-visible="false"></th>
            <th data-checkbox="true">#</th>
            <th data-field="name">Nazwa</th>
            <th data-field="description">Opis</th>
        </tr>
        </thead>
    </table>
</div>

<div class="modal fade" id="createProjectModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
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
                <?php echo form_submit('createProject', 'Utwórz', array('class' => 'btn btn-primary')) ?>
                <?php echo form_submit('createProject', 'Anuluj', array('class' => 'btn btn-default', 'data-dismiss' => 'modal')) ?>
            </div>
            <?php echo form_close(); ?>

        </div>
    </div>
</div>

<div class="modal fade" id="alertDialog" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Operacja niewykonywalna</h4>
            </div>
            <div class="modal-body">
                <p>Nie wybrałeś projektu</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    function getProject() {
        var value =  JSON.stringify($('#projectTable').bootstrapTable('getSelections'));
        if (value != '[]')
        {
            document.getElementById("setProject").value = value;
            document.getElementById("formSubmit").submit();
        }else
        {
            $('#alertDialog').modal()

        }
    }
    function startModal() {
        $('#createProjectModal').modal()
    }
    $('#projectTable').bootstrapTable({
        data: <?php echo $userProjectData ?>
    });
</script>






