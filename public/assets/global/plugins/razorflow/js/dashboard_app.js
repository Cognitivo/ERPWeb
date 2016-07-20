var db;
$(document).ready(function(){
	db = new EmbeddedDashboard ();
	facturaspordia();
	top10products();
	porcentajeprodvendidopordia();
	totalsales();
	db.embedTo("dashboard");
});
function facturaspordia(){
	var facturaspordia = new ChartComponent();
	facturaspordia.lock();
	db.addComponent(facturaspordia);
	$.get('./facturaspordia',function(data){
		var response = JSON.parse(JSON.stringify(data));
		facturaspordia.setDimensions(6,6);
		facturaspordia.setCaption("Facturas por dia");
		facturaspordia.setLabels (response.fecha);
		facturaspordia.addSeries ("cantidadfactura", "Total Facturas", response.cantidadfactura);
		facturaspordia.unlock();
	});
}
function top10products(){
	var top10productperbranch = new ChartComponent();
	top10productperbranch.lock();
	db.addComponent(top10productperbranch);
	$.get('./top10productperbranch',function(data){
		var response = JSON.parse(JSON.stringify(data));
		top10productperbranch.setDimensions(6,6);
		top10productperbranch.setCaption("top 10 productos en 6 meses");
		top10productperbranch.setLabels(response.producto);
		top10productperbranch.addSeries("cantidad","cantidad",response.cantidad);
		top10productperbranch.unlock();
	});
}
function porcentajeprodvendidopordia(){
	var porcentajeprodvendidopordia = new TableComponent ();
	porcentajeprodvendidopordia.lock();
	porcentajeprodvendidopordia.addColumn("name","Producto");
	porcentajeprodvendidopordia.addColumn("fecha","Fecha");
	porcentajeprodvendidopordia.addColumn("porcentaje","Porcentaje");
	db.addComponent(porcentajeprodvendidopordia);
	$.get("./porcentajeprodvendidopordia",function(data){
		var response = JSON.parse(JSON.stringify(data));
		porcentajeprodvendidopordia.addMultipleRows(response);
		porcentajeprodvendidopordia.unlock();
	});
}
function totalsales(){
	var totalsales = new GaugeComponent();
	totalsales.setDimensions(4,4);
	totalsales.setCaption("Total Ventas");
	totalsales.setLimits(0, 100000);

	totalsales.lock();
	db.addComponent(totalsales);
	$.get("./totalsales",function(data){
		response = JSON.parse(JSON.stringify(data));
		totalsales.setValue(response[0].totalsales, {numberPrefix: 'Gs.'});
		totalsales.unlock();
	});
}
// var db = new EmbeddedDashboard ();
//
// var chart = new ChartComponent();
// chart.setDimensions (6, 6);
// chart.setCaption("First Chart");
// chart.setLabels (["Jan", "Feb", "Mar"]);
// chart.addSeries ("beverages", "Beverages", [1355, 1916, 1150]);
// chart.addSeries ("packaged_foods", "Packaged Foods", [1513, 976, 1321]);
// db.addComponent (chart);
//
// var chart2 = new ChartComponent();
// chart2.setDimensions (6, 6);
// chart2.setCaption("Second Chart");
// chart2.setLabels (["A", "B", "C"]);
// chart2.addSeries("series_1", "Series 1", [1, 2, 3]);
// db.addComponent (chart2);
//
// chart.onItemClick (function (params) {
//     chart2.updateSeries ("series_1", [3, 5, 2]);
// });
//
// db.embedTo("dashboard");
