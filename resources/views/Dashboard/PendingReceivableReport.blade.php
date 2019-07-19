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
						  	 <form action="/Export/pendingreceivable" method="GET" class="form-horizontal" role="form">
							<input type="date" id="startDate" name="startDate"/>
								<input type="date" id="endDate" name="endDate"/>
						 <button type="submit" class="btn btn-primary">Export</button>
						  </form>
						</div>
       
					</div>
					<div class="portlet-body" >
					  @foreach ($pendingreceivable->groupBy('Company') as $groupedRows)
						 <b>
						 {{$groupedRows->first()->Company}}
						 </b>	
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
										<td>{{  number_format($value->January,0) }}</td>
										<td>{{  number_format($value->February,0) }}</td>
										<td>{{  number_format($value->March,0) }}</td>
										<td>{{  number_format($value->April,0) }}</td>
										<td>{{  number_format($value->May,0) }}</td>
										<td>{{  number_format($value->June,0) }}</td>
										<td>{{  number_format($value->July,0) }}</td>
										<td>{{  number_format($value->August,0) }}</td>
										<td>{{  number_format($value->September,0) }}</td>
										<td>{{  number_format($value->Octomber,0) }}</td>
										<td>{{  number_format($value->November,0) }}</td>
										<td>{{  number_format($value->December,0) }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						@endforeach
					</div> 
				</div>
			</div> 
		</div>
	
	
	@endsection

	@section('pagescripts')
		@parent
	
	@endsection
