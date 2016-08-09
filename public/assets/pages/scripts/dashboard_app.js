var DashBoard;
var UserComponents = {
    Components: []
};
$(document).ready(function() {
    $.get("./getcomponents", function(Data) {
        ListComponents(Data);
    });
    $("body").on("click", "#SaveDashboard", function(e) {
        if (typeof DashboardComponents !== 'undefined' && DashboardComponents.length > 0) {
            $.get("./savedashboard/" + JSON.stringify(DashboardComponents),function(Response){
							console.log(Response);
						});
        }
    });
});

function ListComponents(Data) {
    ul = document.getElementById("components");
    var compCount = 0;
    var divRow;
    var li;
    var ul;
    Components = JSON.parse(Data);
    $.each(Components, function(key, value) {
        li = "<li><a href='#' data-key='" + value + "' class='nav-link'>" + key + " </a></li>"
        $(ul).append(li);
        compCount++;
    });
}
