var DashBoard;

$(document).ready(function(){
	DashBoard = new EmbeddedDashboard ();
	//api call. person json read.
	//foreach{
	//function
	//}
	SalesXDay();
	Top10Sales();
	SalesByTag_Percent();
	TotalSales();
	Sales_ByFootTraffic();
	averagequantityperinv();
	averagesalesperinv();
	DashBoard.embedTo("dashboard");
});

// function StartChart(){
// 	var Chart = new ChartComponent();
// 	Chart.lock();
// 	DashBoard.addComponent(Chart);
// 	$.get('./kpi/' +  + '', function(data){
// 		var response = JSON.parse(JSON.stringify(data));
// 		Chart.setDimensions(response.D1,response.D2);
// 		Chart.setCaption(response.Title);
// 		Chart.setLabels(response.Label[0]);
// 		foreach (response.Series in response.SEries[]) {
// 			Chart.addSeries(response.Series[0]);
// 		}
//
// 		Chart.unlock();
// 	});
// }

function SalesXDay(){
	var Report = new ChartComponent();
	Report.lock();
	DashBoard.addComponent(Report);
	$.get('./kpi/SalesXDay' + '/2016-07-01/2017-01-01' ,function(data){
		var response = JSON.parse(JSON.stringify(data));
		Report.setDimensions(3,3);
		Report.setCaption("Sales per Day");
		Report.setLabels (response.Date);
		Report.addSeries ("Sales", "Total Sales", response.Sales);
		Report.unlock();
	});
}

function Top10Sales(){
	var Report = new ChartComponent();
	Report.lock();
	DashBoard.addComponent(Report);
	$.get('./kpi/Top10Sales' + '/2016-07-01/2017-01-01' ,function(data){
		var response = JSON.parse(JSON.stringify(data));
		Report.setDimensions(6,6);
		Report.setCaption("Top 10 Items");
		Report.setLabels(response.Item);
		Report.addSeries("Sales","Total Sales",response.Sales,{
			numberPrefix: "$ "
		});
		Report.addSeries("Costs", "Total Costs", response.Costs, {
			numberPrefix: "$ ",
			seriesColor: 'a4c9f3'
		});
		Report.setOption ('stackedTotalDisplay', true);
		Report.unlock();
	});
}

function SalesByTag_Percent(){
	var Report = new ChartComponent();
	Report.lock();
	DashBoard.addComponent(Report);
	$.get('./kpi/SalesByTag_Percent' + '/2016-07-01/2017-01-01' ,function(data){
		var response = JSON.parse(JSON.stringify(data));
		Report.setDimensions(6,6);
		Report.setCaption("Tags as Percentage of Sales");
		Report.setLabels(response.Tag);
		Report.setPieValues(response.Percentage);
		Report.unlock();
	});
}

function TotalSales(){
	var Report = new KPIComponent();
	Report.setDimensions(6,3);
	Report.setCaption("Total Sales");
	Report.lock();
	DashBoard.addComponent(Report);
	$.get('./kpi/TotalSales' + '/2016-07-01/2017-01-01' ,function(data){
		response = JSON.parse(JSON.stringify(data));
		Report.setValue(response[0].Sales);
		Report.unlock();
	});
}

function Sales_ByFootTraffic(){
	var Report = new KPIComponent();
	Report.setDimensions(3,3);
	Report.setCaption("Sales Per Foot Traffic");

	Report.lock();
	DashBoard.addComponent(Report);
	$.get('./kpi/Sales_ByFootTraffic' + '/2016-07-01/2017-01-01' , function(data){
		Report.setValue(data);
		Report.unlock();
	});
}

function averagequantityperinv(){
	var Report = new KPIComponent();
	Report.setDimensions(3,3);
	Report.setCaption("Average Quantity Per Invoice");
	Report.lock();
	DashBoard.addComponent(Report);
	$.get("./averagequantityperinv",function(data){
		response = JSON.parse(JSON.stringify(data));
		Report.setValue(response[0].averagequantityperinv);
		Report.unlock();
	});
}

function averagesalesperinv(){
	var averagesalesperinv = new KPIComponent();
	averagesalesperinv.setDimensions(3,3);
	averagesalesperinv.setCaption("Average Sales Per Invoice");
	averagesalesperinv.lock();
	DashBoard.addComponent(averagesalesperinv);
	$.get("./averagesalesperinv",function(data){
		response = JSON.parse(JSON.stringify(data));
		averagesalesperinv.setValue(response[0].averagesalesperinv);
		averagesalesperinv.unlock();
	});
}
