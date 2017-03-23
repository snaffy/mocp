/**
 * Created by azygm on 09.11.2016.
 */
function setScaleConfig(value){
    switch (value) {
        case "1":
            gantt.config.scale_unit = "day";
            gantt.config.step = 1;
            gantt.config.date_scale = "%d %M";
            gantt.config.subscales = [];
            gantt.config.scale_height = 27;
            gantt.templates.date_scale = null;
            break;
        case "2":
            var weekScaleTemplate = function(date){
                var dateToStr = gantt.date.date_to_str("%d %M");
                var endDate = gantt.date.add(gantt.date.add(date, 1, "week"), -1, "day");
                return dateToStr(date) + " - " + dateToStr(endDate);
            };

            gantt.config.scale_unit = "week";
            gantt.config.step = 1;
            gantt.templates.date_scale = weekScaleTemplate;
            gantt.config.subscales = [
                {unit:"day", step:1, date:"%D" }
            ];
            gantt.config.scale_height = 50;
            break;
        case "3":
            gantt.config.scale_unit = "month";
            gantt.config.date_scale = "%F, %Y";
            gantt.config.subscales = [
                {unit:"day", step:1, date:"%j, %D" }
            ];
            gantt.config.scale_height = 50;
            gantt.templates.date_scale = null;
            break;
        case "4":
            gantt.config.scale_unit = "year";
            gantt.config.step = 1;
            gantt.config.date_scale = "%Y";
            gantt.config.min_column_width = 50;

            gantt.config.scale_height = 90;
            gantt.templates.date_scale = null;


            gantt.config.subscales = [
                {unit:"month", step:1, date:"%M" }
            ];
            break;
    }
}
setScaleConfig('2');


$('#scale').change(function () {
    var selectedText = $(this).find("option:selected").val();
    setScaleConfig(selectedText);
    gantt.render();
});




