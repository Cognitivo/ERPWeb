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
							<i class="fa fa-gift"></i>Pendiente de cobrar
						</div>

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
									<th>January</th>
									<th>Febuary</th>
									<th>March</th>
									<th>April</th>
									<th>May</th>
									<th>June</th>
									<th>July</th>
									<th>August</th>
									<th>September</th>
									<th>Octomber</th>
									<th>November</th>
									<th>December</th>

								</tr>
							</thead>

							<tbody id="pendingReceivable">
								@foreach ($pendingreceivable as $key => $value)
									<tr>
										<td>{{ $value->Contact }}</td>
										<td>{{  number_format($value->January,2) }}</td>
										<td>{{  number_format($value->February,2) }}</td>
										<td>{{  number_format($value->March,2) }}</td>
										<td>{{  number_format($value->April,2) }}</td>
										<td>{{  number_format($value->May,2) }}</td>
										<td>{{  number_format($value->June,2) }}</td>
										<td>{{  number_format($value->July,2) }}</td>
										<td>{{  number_format($value->August,2) }}</td>
										<td>{{  number_format($value->September,2) }}</td>
										<td>{{  number_format($value->Octomber,2) }}</td>
										<td>{{  number_format($value->November,2) }}</td>
										<td>{{  number_format($value->December,2) }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>

					</div> 
				</div>
			</div> 
		</div>
		<div class="row">
			<div class="" id="barpieportlet">

			</div>
		</div>
	@endsection

	@section('pagescripts')
		@parent
		<script src="{{url()}}/assets/pages/scripts/add-dashboard-components.js" type="text/javascript"></script>
	@endsection
