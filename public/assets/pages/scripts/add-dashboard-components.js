

$(document).ready(function() {
    handleComponents();
});
function handleComponents() {
    $.ajax({
        type: "GET",
        url: "./component/getusercomponents",
        cache: false,

        success: function(Response) {
            var data = JSON.parse(Response);
          if(data.hasOwnProperty('error')){
                $.each(data.error, function(key, value) {
                  console.log(value);
              });
            }
            if(data.hasOwnProperty('components')){
                $.each(data.components, function(key, value) {
                  $.get("./component/" + value + "/2016-01-01/2017-01-01", function(Response) {
                      if (Response.Type.toLowerCase() == "kpi") {
                          handleKPI(Response);
                      } else if (Response.Type.toLowerCase() == "piechart") {
                          handlePie(Response);
                      } else if (Response.Type.toLowerCase() == "barchart") {
                          handleBarChart(Response)
                      }
                  }, "json");
              });
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            // alert("Status: " + textStatus); alert("Error: " + errorThrown);
        }
    });
}

function handleKPI(Response) {
    console.log(Response.Key);
    console.log($("#" + Response.Key).length);
    if (!($("#" + Response.Key).length)) {
        var divKPI = '<div class="col-md-3" id="' + Response.Key + '"> <!-- BEGIN WIDGET THUMB --> <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 "> <h4 class="widget-thumb-heading">' + Response.Caption + '</h4> <div class="widget-thumb-wrap"> <i class="widget-thumb-icon bg-green icon-bulb"></i> <div class="widget-thumb-body"> <span class="widget-thumb-subtitle">' + Response.Unit + '</span> <span class="widget-thumb-body-stat" data-counter="counterup" data-value="' + Response[Response.Value] + '">' + Response[Response.Value] + '</span> </div> </div> </div> <!-- END WIDGET THUMB --> </div>';
        if ($(".page-content-inner .widget-row").length) {
            $(".page-content-inner .widget-row").append($(divKPI));
        } else {
            var divWidgetRow = '<div class="row widget-row"></div>';
            $(".page-content-inner").append($(divWidgetRow));
            $(".page-content-inner .widget-row").append($(divKPI));
        }
    }
}

function handleBarChart(Response) {
    var id = Response.Key;
    var datasets = [];
    var ChartLabels = [];
    if (!($("#" + id).length)) {
        var divBar = '<div class="col-md-6"> <canvas id=' + id + ' class="canvas" styde="width:50%; height:50%"></canvas> </div>';
        if ($('#' + id).parent().attr('class') == 'col-md-6') {
            $('#' + id).html("")
        } else {
            $(".page-content-inner").append(divBar);
        }
        var ctx = $("#" + id);
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

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                datasets: datasets,
                labels: ChartLabels,
            },
            options: {

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
        var divPie = '<div class="col-md-6"> <canvas id=' + id + ' class="canvas" styde="width:50%; height:50%"></canvas> </div>';
        if ($('#' + id).parent().attr('class') == 'col-md-6') {
            $('#' + id).html("")
        } else {
            $(".page-content-inner").append(divPie);
        }
        var ctx = $("#" + id);
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



function chunkify(a, n, balanced) {

    if (n < 2)
        return [a];

    var len = a.length,
        out = [],
        i = 0,
        size;

    if (len % n === 0) {
        size = Math.floor(len / n);
        while (i < len) {
            out.push(a.slice(i, i += size));
        }
    } else if (balanced) {
        while (i < len) {
            size = Math.ceil((len - i) / n--);
            out.push(a.slice(i, i += size));
        }
    } else {

        n--;
        size = Math.floor(len / n);
        if (len % size === 0)
            size--;
        while (i < size * n) {
            out.push(a.slice(i, i += size));
        }
        out.push(a.slice(size * n));

    }

    return out;
}
