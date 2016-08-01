

var maxWidth = 4;
var totalWidth = 0;
var rowCounter = 0;

$(document).ready(function(){
  handleComponents();
});

function handleComponents (){
  $("body").on("click","#components li a",function(e){
    var url = $(this).attr("data-key");
    $.get("./kpi/" + url + "/2016-07-01/2017-01-01",function(data){
      console.log(data);
      var Response = JSON.parse(data);
      if(Response.type == "kpi"){
        handleKPI(Response);
      }
      else if (Response.type == "pie") {
        handlePie(Response);
      }
      else if (Response.type == "bar") {
        handleBar(Response)
      }
    });
  });
}

function handleKPI (Response){
  var divKPI = '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <div class="dashboard-stat2 "> <div class="display"> <div class="number"> <h3 class="font-green-sharp"> <span data-counter="counterup" data-value="' + Response.data + '">' + Response.data + '</span> <small class="font-green-sharp">$</small> </h3> <small>TOTAL PROFIT</small> </div> <div class="icon"> <i class="icon-pie-chart"></i> </div> </div> <div class="progress-info"> <div class="progress"> <span style="width: 76%;" class="progress-bar progress-bar-success green-sharp"> <span class="sr-only">76% progress</span> </span> </div> </div> </div> </div>';
  addComponent(Response.Dimensions,divKpi);
}

function addComponent (widthNeeded,newDiv){
  if(!(widthNeeded >= totalWidth && widthNeeded <=maxWidth)){
    rowCounter++;
    $(".page-content-inner").append("<div class='row'" + rowCounter + "></div>");
  }
  $(".row" + rowCounter).append(newDiv);
}
