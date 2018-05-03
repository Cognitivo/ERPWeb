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
	<div class="col-md-4 ">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i>Quantity Per Customer </div>
					<div class="tools">
						<a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
						<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
						<a href="" class="fullscreen" data-original-title="" title=""> </a>
						<a href="javascript:;" class="reload" data-original-title="" title=""> </a>
					</div>
				</div>
				<div class="portlet-body" >
					<table class="table table-condensed" id="table-production-execution-form">
						<thead>
							<tr>
								<th>Contact</th>
								<th>Quantity</th>

							</tr>
						</thead>
						<tbody>
							@foreach ($quantitypercustomer as $key => $value)
								<tr>
									<td>{{ $value->contact }}</td>
									<td>{{ $value->quantity }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>

				</div>
			</div>
		</div>
		<div class="col-md-6" id="barpieportlet" >
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-gift"></i>Sales Per Customer </div>
						<div class="tools">
							<a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
							<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
							<a href="" class="fullscreen" data-original-title="" title=""> </a>
							<a href="javascript:;" class="reload" data-original-title="" title=""> </a>
						</div>
					</div>
					<div class="portlet-body" >
						<table class="table table-condensed" id="table-production-execution-form">
							<thead>
								<tr>
									<th>Contact</th>
									<th>Quantity</th>

								</tr>
							</thead>
							<tbody>
								@foreach ($salespercustomer as $key => $value)
									<tr>
										<td>{{ $value->contact }}</td>
										<td>{{ $value->sales }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>

					</div>
				</div>
			</div>
	@endsection
	@section('pagescripts')
		@parent
		<script src="{{url()}}/assets/pages/scripts/add-dashboard-components.js" type="text/javascript"></script>
	@endsection
