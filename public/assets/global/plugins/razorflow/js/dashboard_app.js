var db;
$(document).ready(function(){
	db = new EmbeddedDashboard ();
	facturaspordia();
	top10products();
	porcentajetag();
	totalsales();
	salesperfootfall();
	averagequantityperinv();
	averagesalesperinv();
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
function porcentajetag(){
	var porcentajetag = new ChartComponent ();
	porcentajetag.lock();
	db.addComponent(porcentajetag);
	$.get("./porcentajetag",function(data){
		var response = JSON.parse(JSON.stringify(data));
		porcentajetag.setDimensions(6,6);
		porcentajetag.setCaption("Porcentaje de Categoria Vendido");
		porcentajetag.setLabels(response.tags);
		porcentajetag.setPieValues(response.percentage);
		porcentajetag.unlock();
	});
}
function totalsales(){
	var totalsales = new KPIComponent();
	totalsales.setDimensions(6,3);
	totalsales.setCaption("Total Ventas");

	totalsales.lock();
	db.addComponent(totalsales);
	$.get("./totalsales",function(data){
		response = JSON.parse(JSON.stringify(data));
		totalsales.setValue(response[0].totalsales);
		totalsales.unlock();
	});
}
function salesperfootfall(){
	var salesperfootfall = new KPIComponent();
	salesperfootfall.setDimensions(3,3);
	salesperfootfall.setCaption("Sales Per Footfall");

	salesperfootfall.lock();
	db.addComponent(salesperfootfall);
	$.get("./salesperfootfall",function(data){
		console.log(data);
		salesperfootfall.setValue(data);
		salesperfootfall.unlock();
	});
}
function averagequantityperinv(){
	var averagequantityperinv = new KPIComponent();
	averagequantityperinv.setDimensions(3,3);
	averagequantityperinv.setCaption("Average Quantity Per Invoice");
	averagequantityperinv.lock();
	db.addComponent(averagequantityperinv);
	$.get("./averagequantityperinv",function(data){
		response = JSON.parse(JSON.stringify(data));
		averagequantityperinv.setValue(response[0].averagequantityperinv);
		averagequantityperinv.unlock();
	});
}
function averagesalesperinv(){
	var averagesalesperinv = new KPIComponent();
	averagesalesperinv.setDimensions(3,3);
	averagesalesperinv.setCaption("Average Sales Per Invoice");
	averagesalesperinv.lock();
	db.addComponent(averagesalesperinv);
	$.get("./averagesalesperinv",function(data){
		response = JSON.parse(JSON.stringify(data));
		averagesalesperinv.setValue(response[0].averagesalesperinv);
		averagesalesperinv.unlock();
	});
}
