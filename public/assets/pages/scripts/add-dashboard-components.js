

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
      
      
      //var Response = JSON.parse(data);
      var Response = data;
      console.log(Response)
      if(Response.type == "kpi"){
        handleKPI(Response);
      }
      else if (Response.type == "pie") {
        handlePie(Response);
      }
      else if (Response.type == "bar") {
        handleBarChart(Response)
      }
    });
  });
}

function handleKPI (Response){
  var divKPI = '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> <div class="dashboard-stat2 "> <div class="display"> <div class="number"> <h3 class="font-green-sharp"> <span data-counter="counterup" data-value="' + Response.data + '">' + Response.data + '</span> <small class="font-green-sharp">$</small> </h3> <small>TOTAL PROFIT</small> </div> <div class="icon"> <i class="icon-pie-chart"></i> </div> </div> <div class="progress-info"> <div class="progress"> <span style="width: 76%;" class="progress-bar progress-bar-success green-sharp"> <span class="sr-only">76% progress</span> </span> </div> </div> </div> </div>';
  addComponent(Response.Dimensions,divKpi);
}

function handleBarChart(Response){
 // console.log(Response.name)
var id=Response.caption.replace(/ /g,'')
  var divBar= '<div class="col-md-6"> <canvas id='+id+' class="canvas" styde="width:50%; height:50%"></canvas> </div>'
  //console.log($('#'+id).parent())
  if($('#'+id).parent().attr('class')=='col-md-6'){
      $('#'+id).html("")    
  }else{
     $("#dashboard").append(divBar);
  }
 
  var ctx = $("#"+id);
 var data_label=[]
 var data_name=[]
 var cont=0
  $.each(Response.name,function(v,k){    
    data_name.push(k.Id)
    cont++
  })
   
   console.log(data_name)
 
  var data_value_sales = []
  var data_value_cost = [] 
  var data_value=[] 
  $.each(Response.data,function(v,k){  
    data_label.push(k.Item)
    data_value_sales.push(k.Sales)
    data_value_cost.push(k.Costs)
    for (var i = 0; i < cont; i++) {
     
         console.log(k[data_name[i]])
         data_value.push(data_name[i]+"\t"+k[data_name[i]]) 
  }
  })

console.log(data_value)

 
  
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: data_label,
        datasets: [{
            label: data_name[0],
            backgroundColor:   randomColor(),
            data: data_value_sales,
            borderColor: randomColor(),            
            borderWidth: 1
        },{
          label: data_name[1],
            backgroundColor:   randomColor(),
            data: data_value_cost,
             borderColor: randomColor(),  
            borderWidth: 1 
        }]
    },
    options: {
  
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }],
            xAxes: [{
                ticks: {
                    display: false
                }
            }]
        }
    }
});
 
}

function handlePie(Response){
var id=Response.caption.replace(/ /g,'')
var divBar= '<div class="col-md-6"> <canvas id='+id+' class="canvas" styde="width:50%; height:50%"></canvas> </div>'
  if($('#'+id).parent().attr('class')=='col-md-6'){
      $('#'+id).html("")    
  }else{
     $("#dashboard").append(divBar);
  }
  var data_label=[]
  var data_value = []
  var array_color=[]

$.each(Response.data,function(v,k){  
    data_label.push(k.Tag)
  data_value.push(k.Percentage)
   array_color.push(randomColor())
  })

  var ctx = $("#"+id);
  var data = {
    labels: data_label,
    datasets: [
        {
            data: data_value,
            backgroundColor: array_color,               
            hoverBackgroundColor: array_color,
            
        }]
};
   var myPieChart = new Chart(ctx,{
    type: 'pie',
    data: data,
    options:  {
  
                    responsive: true,
                    legend: {
                        position: 'top',
                    }}
});
}

function addComponent (widthNeeded,newDiv){
  if(!(widthNeeded >= totalWidth && widthNeeded <=maxWidth)){
    rowCounter++;
    $(".page-content-inner").append("<div class='row'" + rowCounter + "></div>");
  }
  $(".row" + rowCounter).append(newDiv);
}

var randomColorFactor = function() {
        return Math.round(Math.random() * 255);
    };
 var randomColor = function(opacity) {
        return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
    };