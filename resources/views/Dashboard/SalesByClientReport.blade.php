@extends('../../master')

@section('title', 'Dashboard | CognitivoERP')
@section('Title', 'Dashboard')

@section('pagesettings')
	
@endsection

@section('innercontent')
	<div class="col-md-6" id="barpieportlet" style="display:none;">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i>Portlet </div>
					<div class="tools">
						<a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
						<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
						<a href="" class="fullscreen" data-original-title="" title=""> </a>
						<a href="javascript:;" class="reload" data-original-title="" title=""> </a>
					</div>
				</div>
				<div class="portlet-body" style="display: block;">  </div>
			</div>
		</div>
	
		<div class="row">
	     	<div class="col">
				<div class="portlet">
					 <div class="portlet-title">
						<div class="caption">
							<i class="fa fa-gift"></i> Ventas por Empresa
						</div>

						<div class="tools">
						 <form action="/SalesByClient" method="GET" class="form-horizontal" role="form">
							<input type="date" id="startDate" name="startDate"/>
						 <button type="submit" class="btn btn-primary">Refresh</button>
                  		</form>
       
						</div>
					</div>
					<div class="portlet-body" >
						<table class="table table-condensed" id="table-production-execution-form" >
							<thead>
								<tr>
									<th>Empresa</th>
									<th>Fecha</th>
									<th>Cliente</th>
									<th>Nro de Factura</th>
									<th>Cantidad Total</th>
									<th>Valor Total</th>
								</tr>
							</thead>
							<tbody id="QuantityPerSales">
									@foreach ($SalesByClient as $value)
									<tr>
									  	<td>{{ $value->company }}</td>
										<td>{{ $value->date }}</td>
										<td>{{ $value->alias }}</td>
										<td>{{ $value->number }}</td>
										<td>{{ number_format($value->quantity, 0) }}</td>
										<td>{{ number_format($value->subTotalVat, 0) }}</td>
										<td>{{ $value->currency }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div> 
		</div>
		
	@endsection

	@section('pagescripts')
		@parent
	
	@endsection
