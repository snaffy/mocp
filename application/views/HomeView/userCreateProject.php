<!--BUTTONS-->
<div id="custom-toolbar">
    <div class="form-group">
        <?php echo form_open('home', array('id' => 'projectHome')) ?>
        <?php echo form_button('createProjectBtn', 'Utwórz projekt', array('class' => 'btn btn-primary btn-lg', 'id' => 'createProjectBtn', 'onclick' => "createProject()")); ?>
        <?php echo form_button('editProjectBtn', 'Edytuj', array('class' => 'btn btn-primary', 'id' => 'editProjectBtn', 'onclick' => "getToEdit()")); ?>
        <?php echo form_button('deleteProjectBtn', 'Usuń projekt', array('class' => 'btn btn-danger', 'id' => 'deleteProjectBtn', 'onclick' => 'getToRemove()')); ?>
        <input type="hidden" name="selectedProjectIDToRem" value="" id="selectedProjectIDToRem"/>
        <?php echo form_close(); ?>
    </div>

</div>
<!--TABLE WITH PROJECT -->

<div class="container">
    <h2> Moje projekty</h2>
    <div class="form-group">
        <?php echo form_open('project', array('id' => 'projectManage')) ?>
        <?php echo form_button('selectProjectBtn', 'Wybierz', array('class' => 'btn btn-success', 'id' => 'selectProjectBtn', 'onclick' => "selectProject()")); ?>
        <input type="hidden" name="selectedProjectID" value="" id="selectedProjectID"/>
        <?php echo form_close(); ?>
    </div>
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
<!--MODAL WINDOWS -->
<div class="modal fade" id="createEditProjectModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Utwórz/Edytuj projekt </h4>
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
                <div class="form-group">
                    <input type="hidden" name="projectID" id="projectID" value=""/>
                </div>
            </div>
            <div class="modal-footer">
                <?php echo form_submit('createEditSubmit', '', array('class' => 'btn btn-primary', 'id' => 'createEditSubmit')) ?>
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
    function getIDProject() {
        var value = JSON.stringify($('#projectTable').bootstrapTable('getSelections'));
        if (value != '[]') {
            var data = JSON.parse(value);
            return data[0].idProject;
        } else {
            return false;
        }
    }
    function getToRemove()
    {
        if(getIDProject() != false)
        {
            document.getElementById('selectedProjectIDToRem').value = getIDProject();
            document.getElementById("projectHome").submit();
        }else 
        {
            $('#alertDialog').modal();
        }
    }
    function selectProject() {
        if(getIDProject() != false)
        {
            document.getElementById('selectedProjectID').value = getIDProject();
            document.getElementById("projectManage").submit();
        }else
        {
            $('#alertDialog').modal();
        }
    }
    function getToEdit() {
        if (getIDProject() != false) {
            document.getElementById('projectID').value = getIDProject();
            document.getElementById('createEditSubmit').value = 'Edytuj';
            $('#createEditProjectModal').modal()
        } else {
            $('#alertDialog').modal();
        }
    }
    function createProject() {
        document.getElementById('createEditSubmit').value = 'Utwórz';
        //document.getElementById('projectName').value = 'Nowy Projekt'
        $('#createEditProjectModal').modal()
    }
    $('#projectTable').bootstrapTable({
        data: <?php echo $userProjectData ?>
    });
</script>






