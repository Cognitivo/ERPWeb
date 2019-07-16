@extends('../../master')

@section('title', 'Dashboard | CognitivoERP')
@section('Title', 'Dashboard')

@section('pagesettings')
	<div class="col-md-4">
		
	</div>
@endsection

@section('innercontent')
	<div class="col-md-6" id="barpieportlet" style="display:none;">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i>Portlet </div>
					
				</div>
				
			</div>
		</div>
	
		<div class="row">
	     	<div class="col-md-6">
			
			    @foreach ($pendingreceivable->groupBy('company') as $groupedRows)
			
				<div class="portlet">
					 <div class="portlet-title">
						<div class="caption">
							<i class="fa fa-gift"></i>Pendiente de cobrar
						</div>
						<div class="tools">
					 <form action="/pendingreceivable" method="GET" class="form-horizontal" role="form">
							<input type="date" id="startDate" name="startDate"/>
								<input type="date" id="endDate" name="endDate"/>
						 <button type="submit" class="btn btn-primary">Refresh</button>
						  </form>
						</div>
       
					</div>
					<div class="portlet-body" >
						<table class="table table-condensed" id="table-production-execution-form">
							<thead>
								<tr>
									<th>Cliente</th>
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
								@foreach ($groupedRows as $key => $value)
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
		@endforeach
	
	@endsection

	@section('pagescripts')
		@parent
	
	@endsection
