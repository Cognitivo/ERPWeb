
$(document).ready(function(){
  $.get('./getconfig',function(response){
		var components = $.parseJSON(response);
    showcomponents(components);
	});
});

function showcomponents(components){
  console.log(components[1].KPIS);
  divComponents = document.getElementById("components");
  var compCount = 0;
  var divRow;
  var li;
  components.KPIS.forEach(function(kpi){
    if(compCount % 11 == 0){
      divRow = document.createElement("div");
      divRow.addClass("col-md-4");
      $(divComponents).append(divRow);
    }
    li = "<li><a href='kpi.function'>" + kpi.name +" </a></li>"
  });
  //components.components.forEach(function(comp){});
}
