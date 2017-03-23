/**
 * Created by azygm on 14.12.2016.
 */
function getLinkedTask2(initial_task,new_date_end,new_date_start) {
        var outcoming = initial_task.$source;
        // console.log(outcoming);
        for ( var i = 0; i <= outcoming.length-1; i++) {
            var link = gantt.getLink(outcoming[i]);
            var target = gantt.getTask(link.target);
            var taskID = target.id;
            var diff;
            if (link.type == 0)
            {
                if (new_date_end > target.start_date)
                {
                    diff = new_date_end - target.start_date;
                    target.start_date =  new Date(+target.start_date+diff);
                    target.end_date =  new Date(+target.end_date+diff);
                    // new_date = target.end_date;
                }
            }
            if(link.type == 1)
            {
                if( new_date_start > target.start_date)
                {
                    diff = new_date_start - target.start_date;
                    target.start_date =  new Date(+target.start_date+diff);
                    target.end_date =  new Date(+target.end_date+diff);
                    // new_date = target.end_date;
                }
            }
            if (link.type == 2 )
            {
                // alert("tas");
                if (new_date_end > target.end_date)
                {
                    diff = new_date_end - target.end_date;
                    target.start_date =  new Date(+target.start_date+diff);
                    target.end_date =  new Date(+target.end_date+diff);
                    // new_date = target.end_date;
                }
            }
            if(link.type == 3)
            {
                if( new_date_start > target.end_date)
                {
                    diff = new_date_start - target.end_date;
                    target.start_date =  new Date(+target.start_date+diff);
                    target.end_date =  new Date(+target.end_date+diff);
                    // new_date = target.end_date;
                }
            }
            gantt.updateTask(taskID);
            getLinkedTask2(target,target.end_date,target.start_date);
        }

}