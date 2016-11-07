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
    gantt.load("http://localhost:449/mocp/project/data");
//    var tmp ={"data":[{"id":"1","text":"New task","duration":1,"progress":0.54723926380368,"sortorder":null,"parent":0,"start_date":"03-11-2016 00:00","end_date":"04-11-2016 00:00"},{"id":"2","text":"New task","duration":1,"progress":null,"sortorder":null,"parent":0,"start_date":"04-11-2016 00:00","end_date":"05-11-2016 00:00"}],"links":[]}
//    gantt.parse(tmp);

    var dp = new gantt.dataProcessor("http://localhost:449/mocp/project/data");
    dp.init(gantt);
    dp.setTransactionMode("REST");
    function getGanttData() {
        var json = gantt.serialize();
        gantt.updateLink()
        var jsonP = JSON.stringify(json);
        document.getElementById('addTaskInput').value = jsonP;
        document.getElementById("formAddTask").submit();
    }
    
</script>

