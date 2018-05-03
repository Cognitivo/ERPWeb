

$(document).ready(function() {
    $(".page-content-inner").sortable({
        handle:".widget-thumb-heading",
        connectWith:".draggable",
        opacity: 0.8,
        coneHelperSize: true,
        placeholder: 'portlet-sortable-placeholder',
        forcePlaceholderSize: true,
        tolerance: "pointer",
        helper: "clone",
        cursor:"move"
      }).disableSelection();
    handleComponents();
});
function handleComponents(startdate,enddate) {
    
    if (typeof startdate === 'undefined') { startdate = moment().startOf("year").format('YYYY-MM-DD'); }
    if (typeof enddate === 'undefined') { enddate = moment().format('YYYY-MM-DD'); }
    

    $.ajax({
        type: "GET",
        url: "./component/getusercomponents",
        cache: false,

        success: function(Response) {
            var data = JSON.parse(Response);
            $.each(data, function(key, value) {
              $.get("./component/" + key + "/" + startdate + "/" + enddate, function(Response) {
                  if (Response.Type.toLowerCase() == "kpi") {
                      handleKPI(Response);
                  } else if (Response.Type.toLowerCase() == "piechart") {
                      handlePie(Response);
                  } else if (Response.Type.toLowerCase() == "barchart") {
                      handleBarChart(Response)
                  }
              }, "json");
          });
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            // alert("Status: " + textStatus); alert("Error: " + errorThrown);
        }
    });
    $.ajax({
        type: "GET",
        url: "./gettables/" + startdate + "/" + enddate,
        cache: false,

        success: function(Response) {
            PopulateTableQuantity(Response['quantitypercustomer'],'QuantityPerCustomer');

            PopulateTableSales(Response['salespercustomer'],'SalesPerCustomer');

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            // alert("Status: " + textStatus); alert("Error: " + errorThrown);
        }
    });
}

function PopulateTableQuantity(data,id){
    var tableBody = $("#" + id);
    tableBody.empty();
    if(data == 'No hay datos'){
        var row = "<tr><td>No hay Datos</td></tr>"
    }
    else{
        $.each(data,function(key,value){
            var row = "<tr><td>" + value['contact'] + "</td><td>" + value['quantity']+ "</td></tr>"
            tableBody.append(row);
        });
    }
    
}

function PopulateTableSales(data,id){
    console.log(data);
    var tableBody = $("#" + id);
    tableBody.empty();
    if(data == 'No hay datos'){
        var row = "<tr><td>No hay Datos</td></tr>"
    }
    else{
        $.each(data,function(key,value){
            var row = "<tr><td>" + value['contact'] + "</td><td>" + value['sales']+ "</td></tr>"
            tableBody.append(row);
        });
    }
    
}
function handleKPI(Response) {
    if (!($("#" + Response.Key).length)) {
        var divKPI = '<div class="col-md-3 draggable" id="' + Response.Key + '"> <!-- BEGIN WIDGET THUMB --> <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 "> <h4 class="widget-thumb-heading">' + Response.Caption + '</h4> <div class="widget-thumb-wrap"> <i class="widget-thumb-icon bg-green icon-bulb"></i> <div class="widget-thumb-body"> <span class="widget-thumb-subtitle">' + Response.Unit + '</span> <span class="widget-thumb-body-stat" id="' + Response.Key + 'body" data-counter="counterup" data-value="' + Response[Response.Value] + '">' + Response[Response.Value] + '</span> </div> </div> </div> <!-- END WIDGET THUMB --> </div>';
        if ($(".page-content-inner .widget-row").length) {
            $(".page-content-inner .widget-row").append($(divKPI));
        } else {
            var divWidgetRow = '<div class="row widget-row"></div>';
            $(".page-content-inner").append($(divWidgetRow));
            $(".page-content-inner .widget-row").append($(divKPI));
        }
        $(".page-content-inner").sortable('refresh');
    }
    else{
        $("#" + Response.Key + "body").html(Response[Response.Value]);
    }
}

function handleBarChart(Response) {
    var id = Response.Key;
    var datasets = [];
    var ChartLabels = [];
    var myChart;
    if (!($("#" + id).length)) {
        var PortletBar = $("#barpieportlet").clone();
        $(PortletBar).removeAttr("id");
        $(PortletBar).attr("id",id);
        $(PortletBar).removeAttr("style");
        if ($('#canvas' + id).parent().attr('class') == 'portlet-body') {
            $('#canvas' + id).html("");
        }else{
        $(".page-content-inner").append(PortletBar);
        }
        $("#" + id + " .portlet-title .caption").html(Response.Caption);
        var divBar = '<canvas class="canvas" id="canvas' +id +'"></canvas>';
        $("#" + id + " .portlet-body").append(divBar);
        var ctx = $("#canvas" + id);
        $.each(Response[Response.Label], function(key, value) {
            ChartLabels.push(value);
        })
        $.each(Response.Series, function(key, value) {
            datasets.push({
                label: Response.Series[key].Name,
                backgroundColor: Response.Series[key].Color,
                data: Response[Response.Series[key].Column],
                borderColor: randomColor(),
                borderWidth: 1
            });
        });
        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                datasets: datasets,
                labels: ChartLabels,
            },
            options: {
                scaleLabel:
                    function(label){return  '$' + label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");},
                responsive: true,
                legend: {
                    position: 'top',
                }
            }
        });
    }
    else{
        $('#canvas' + id).remove();
        $("#" + id + " .portlet-body").append('<canvas class="canvas" id="canvas' +id +'"></canvas>');
        var ctx = $("#canvas" + id);
        $.each(Response[Response.Label], function(key, value) {
            ChartLabels.push(value);
        })
        $.each(Response.Series, function(key, value) {
            datasets.push({
                label: Response.Series[key].Name,
                backgroundColor: Response.Series[key].Color,
                data: Response[Response.Series[key].Column],
                borderColor: randomColor(),
                borderWidth: 1
            });
        });
        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                datasets: datasets,
                labels: ChartLabels,
            },
            options: {
                scaleLabel:
                    function(label){return  '$' + label.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");},
                responsive: true,
                legend: {
                    position: 'top',
                }
            }
        });
    }
}

function handlePie(Response) {
    var id = Response.Key;
    var ChartLabels = [];
    var DataSets = [];

    if (!($("#" + id).length)) {
        var PortletPie = $("#barpieportlet").clone();
        $(PortletPie).removeAttr("id");
        $(PortletPie).attr("id",id);
        $(PortletPie).removeAttr("style");
        $(".page-content-inner").append(PortletPie);
        $("#" + id + " .portlet-title .caption").html(Response.Caption);
        var divPie = '<canvas id=canvas' + id + ' class="canvas" styde="width:50%; height:50%"></canvas>';
        if ($('#canvas' + id).parent().attr('class') == 'portlet-body') {
            $('#canvas' + id).html("")
        } else {
            $("#" + id + " .portlet-body").append(divPie);
        }
        var ctx = $("#canvas" + id);
        $.each(Response[Response.Label],function(key,value){
            ChartLabels.push(value);
        });
        DataSets.push({
            data:Response[Response.PieValues],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ],
            hoverBackgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ]
        });
        var myPieChart = new Chart(ctx,{
            type: 'pie',
            data: {labels:ChartLabels,
                    datasets:DataSets},
            options: {

                responsive: true,
                legend: {
                    position: 'top',
                }
            }
        });
    }
    else{
        $('#canvas' + id).remove();
        $("#" + id + " .portlet-body").append('<canvas id=canvas' + id + ' class="canvas" styde="width:50%; height:50%"></canvas>');
        var ctx = $("#canvas" + id);
        var ctx = $("#canvas" + id);
        $.each(Response[Response.Label],function(key,value){
            ChartLabels.push(value);
        });
        DataSets.push({
            data:Response[Response.PieValues],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ],
            hoverBackgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ]
        });
        var myPieChart = new Chart(ctx,{
            type: 'pie',
            data: {labels:ChartLabels,
                    datasets:DataSets},
            options: {

                responsive: true,
                legend: {
                    position: 'top',
                }
            }
        });
    }
}

var randomColorFactor = function() {
    return Math.round(Math.random() * 255);
};
var randomColor = function(opacity) {
    return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
};
