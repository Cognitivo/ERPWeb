@extends('../../master')

@section('title', 'Dashboard | CognitivoERP')
@section('Title', 'Dashboard')

@section('pagesettings')
	<div class="col-md-4">
		<div id="reportrange" class="btn default">
			<i class="fa fa-calendar"></i> &nbsp;
			<span></span>
			<b class="fa fa-angle-down"></b>
		</div>
	</div>
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
	     	<div class="col-md-6">
				<div class="portlet">
					 <div class="portlet-title">
						<div class="caption">
							<i class="fa fa-gift"></i>Sales Margin
						</div>

						<div class="tools">
							<a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
							<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
							<a href="" class="fullscreen" data-original-title="" title=""> </a>
							<a href="javascript:;" class="reload" data-original-title="" title=""> </a>
						</div>
					</div>
					<div class="portlet-body" >
						<table class="table table-condensed" id="table-production-execution-form" >
							<thead>
								<tr>
									<th>Number</th>
								    <th>Item</th>
									<th>Cantidad</th>
									<th>precio unitario</th>
									<th>precio unitario</th>
									<th>cuba subtotal</th>
									<th>descuento</th>
									<th>Margen</th>
									<th>Mark Up</th>
									<th>Mark Up</th>
									<th>Lucro</th>
								</tr>
							</thead>
							<tbody id="QuantityPerSales">
							@foreach ($salesmargin as $key => $value)
									<tr>
									    <td>{{ $value->Number }}</td>
										<td>{{ $value->Items }}</td>
										<td>{{ number_format($value->Quantity,2) }}</td>
										<td>{{ number_format($value->UnitPrice,2) }}</td>
										<td>{{ number_format($value->SubTotalVat,2) }}</td>
										<td>{{ number_format($value->Discount,2) }}</td>
										<td>{{ number_format($value->Margin,2) }}</td>
										<td>{{ number_format($value->MarkUp,2) }}</td>
										<td>{{ number_format($value->Profit,2) }}</td>
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
		<script src="{{url()}}/assets/pages/scripts/add-dashboard-components.js" type="text/javascript"></script>
	@endsection
