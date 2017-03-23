/**
 * Created by azygm on 09.11.2016.
 */
gantt.locale.labels["complete_button"] = "Complete";
gantt.config.buttons_left=["dhx_save_btn","dhx_cancel_btn","complete_button"];

gantt.templates.task_class=function(start,end,task){
    if (task.progress == 1)
        return "completed_task";
    return "";
};
gantt.attachEvent("onLightboxButton", function(button_id, node, e){
    if(button_id == "complete_button"){
        var id = gantt.getState().lightbox;
        gantt.getTask(id).progress = 1;
        gantt.updateTask(id)
        gantt.hideLightbox();
    }
});
gantt.attachEvent("onBeforeLightbox", function(id) {
    var task = gantt.getTask(id);
    if (task.progress == 1){
        gantt.message({text:"Zadaie zostało zakończone!", type:"completed"});
        return false;
    }
    return true;
});
