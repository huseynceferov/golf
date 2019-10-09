var $eventLog = $(".js-event-log");
var $eventSelect = $(".multiSelect2");

$eventSelect.select2();

/*$eventSelect.on("select2:open", function (e) { log("select2:open", e); });
 $eventSelect.on("select2:close", function (e) { log("select2:close", e); });*/
$eventSelect.on("select2:select", function (e) { log("select2:select", e); });
$eventSelect.on("select2:unselect", function (e) { log("select2:unselect", e); });

/*$eventSelect.on("change", function (e) { log("change"); });*/

function log (name, evt) {
    if (!evt) {
        var args = "{}";
    } else {
        var args = JSON.stringify(evt.params, function (key, value) {
            //console.log(evt.params);
            if (value && value.nodeName) return "[DOM node]";
            if (value instanceof $.Event) return "[$.Event]";
            return value;
        });
    }
    console.log(evt.params.data.id);
    //console.log(name);
    /*var $e = $("<li>" + name + " -> " + args + "</li>");
     $eventLog.append($e);
     $e.animate({ opacity: 1 }, 10000, 'linear', function () {
     $e.animate({ opacity: 0 }, 5000, 'linear', function () {
     $e.remove();
     });
     });*/
}