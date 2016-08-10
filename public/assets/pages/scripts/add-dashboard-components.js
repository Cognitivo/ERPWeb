var DashboardComponents = [];

$(document).ready(function() {
    handleComponents();
});

<<<<<<< HEAD
function handleComponents (){
  $("body").on("click","#components li a",function(e){
    var url = $(this).attr("data-key");
    $.get("./kpi/" + url + "/2016-07-01/2017-01-01",function(data){


      //var Response = JSON.parse(data);
      var Response = data;
      console.log(Response);
      if(Response.type == "kpi"){
        handleKPI(Response);
      }
      else if (Response.type == "pie") {
        handlePie(Response);
      }
      else if (Response.type == "bar") {
        handleBarChart(Response)
      }
=======
function handleComponents() {
    $("body").on("click", "#components li a", function(e) {
        var url = $(this).attr("data-key");
        $.get("./kpi/" + url + "/2016-01-01/2017-01-01", function(Response) {
            if (Response.Type.toLowerCase() == "kpi") {
                handleKPI(Response);
            } else if (Response.Type.toLowerCase() == "piechart") {
                handlePie(Response);
            } else if (Response.Type.toLowerCase() == "barchart") {
                handleBarChart(Response)
            }
        }, "json");
>>>>>>> ce8d3a1339d5e7fe0e0427372e51f828eb85bbee
    });
}

function handleKPI(Response) {
    if (!($("#" + Response.Key).length)) {
        var divKPI = '<div class="col-md-3" id="' + Response.Key + '"> <!-- BEGIN WIDGET THUMB --> <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 "> <h4 class="widget-thumb-heading">' + Response.Caption + '</h4> <div class="widget-thumb-wrap"> <i class="widget-thumb-icon bg-green icon-bulb"></i> <div class="widget-thumb-body"> <span class="widget-thumb-subtitle">' + Response.Unit + '</span> <span class="widget-thumb-body-stat" data-counter="counterup" data-value="' + Response[Response.Value] + '">' + Response[Response.Value] + '</span> </div> </div> </div> <!-- END WIDGET THUMB --> </div>';
        if ($(".page-content-inner .widget-row").length) {
            $(".page-content-inner .widget-row").append($(divKPI));
        } else {
            var divWidgetRow = '<div class="row widget-row"></div>';
            $(".page-content-inner").append($(divWidgetRow));
            $(".page-content-inner .widget-row").append($(divKPI));
        }
        DashboardComponents.push(Response.Key);
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
        DashboardComponents.push(Response.Key);
    }


}

function handlePie(Response) {
    var id = Response.caption.replace(/ /g, '')
    var divBar = '<div class="col-md-6"> <canvas id=' + id + ' class="canvas" styde="width:50%; height:50%"></canvas> </div>'
    if ($('#' + id).parent().attr('class') == 'col-md-6') {
        $('#' + id).html("")
    } else {
        $("#dashboard").append(divBar);
    }
    var data_label = []
    var data_value = []
    var array_color = []

    $.each(Response.data, function(v, k) {
        data_label.push(k.Tag)
        data_value.push(k.Percentage)
        array_color.push(randomColor())
    })

    var ctx = $("#" + id);
    var data = {
        labels: data_label,
        datasets: [{
            data: data_value,
            backgroundColor: array_color,
            hoverBackgroundColor: array_color,

        }]
    };
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: {

            responsive: true,
            legend: {
                position: 'top',
            }
        }
    });
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
