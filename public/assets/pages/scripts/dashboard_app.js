var DashBoard;
var UserComponents = {Components:[]};
$(document).ready(function(){
	$.get("./getcomponents",function(Data){
		ListComponents(Data);
	});
});

function ListComponents(Data){
  ul = document.getElementById("components");
  var compCount = 0;
  var divRow;
  var li;
  var ul;
	Components = JSON.parse(Data);
  $.each(Components,function(key,value){
    li = "<li><a href='#' data-key='" + value + "' class='nav-link'>" + key +" </a></li>"
    $(ul).append(li);
    compCount++;
  });
}
