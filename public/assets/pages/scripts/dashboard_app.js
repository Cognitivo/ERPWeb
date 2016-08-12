var DashBoard;

var DashboardComponents = [];
$(document).ready(function() {

  $("body").on("click", "#ListComponents", function(e) {
    $.get("./listcomponents",function(Response){
      $("#ShowComponents").append(Response);
    });
  });
  $("body").on("click", "#AddComponents", function(e) {
    $('#components :checked').each(function() {
      DashboardComponents.push($(this).val());
      $("#UserComponents").append("<li>" + $(this).next('label').text() + "</li>")
    });
  });
    $("body").on("click", "#UpdateUserDashboard", function(e) {
			var JsonString = JSON.stringify(DashboardComponents);
        if (typeof DashboardComponents !== 'undefined' && DashboardComponents.length > 0) {
            $.ajax({
                type: "POST",
                url: "./savedashboard",
                data: {components:JsonString},
                cache: false,

                success: function(Response) {
                    console.log(Response);
                }
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
