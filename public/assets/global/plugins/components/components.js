
$(document).ready(function(){
  $.get('./getconfig',function(response){
		var components = $.parseJSON(response);
    showcomponents(components);
	});
});

function showcomponents(components){
  divComponents = document.getElementById("components");
  var compCount = 0;
  var divRow;
  var li;
  var ul;
  components.KPIS.forEach(function(kpi){
    if(compCount % 11 == 0){
      divRow = document.createElement("div");
      ul = document.createElement("ul");
      $(ul).addClass = "mega-menu-submenu";
      $(divRow).addClass("col-md-4");
      $(divRow).append(ul);
      $(divComponents).append(divRow);
    }
    li = "<li><a href='javascript:" + kpi.function + "();'>" + kpi.name +" </a></li>"
    $(ul).append(li);
    compCount++;
  });
  //components.components.forEach(function(comp){});
}
