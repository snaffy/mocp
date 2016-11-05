<!--<style type="text/css">-->
<!--    html, body { height: 100%; padding:0px; margin:0px; overflow: hidden; }-->
<!--</style>-->
<div class="cointainer">
    <div class="col-xs-offset-1">
        <div id="gantt_here" style='width:90%; height:60%;'></div>
    </div>

</div>
<div class="cointainer">
    <?php echo form_open('project/task', array("id" => "formAddTask")) ?>
    <?php echo form_button('addTask', 'Dodaj Zadanie', array('class' => 'btn btn-primary active', 'id' => 'addTask',
        'onclick' => 'getGanttData()')) ?>
    <input id="addTaskInput" name="addTaskInput" type="hidden" class="form-control" value=""/>
    <?php echo form_close() ?>
</div>

<script type="text/javascript">

    gantt.config.scale_unit = "day";
    gantt.config.date_scale = "%j";
    gantt.config.step = 2;

    gantt.config.scale_height = 30;
    gantt.init("gantt_here");
    var task_data =  <?php echo $task_data;?>;

    gantt.parse(task_data);

    function getGanttData() {
        var json = gantt.serialize();
        var jsonP = JSON.stringify(json);
        document.getElementById('addTaskInput').value = jsonP;
        document.getElementById("formAddTask").submit();
    }
    
</script>

