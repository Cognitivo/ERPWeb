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
					 <form action="/salesByMonth" method="GET" class="form-horizontal" role="form">
							<input type="date" id="startDate" name="startDate"/>
								<input type="date" id="endDate" name="endDate"/>
						 <button type="submit" class="btn btn-primary">Refresh</button>
						  </form> 
						  <form action="/Export/salesByMonth" method="GET" class="form-horizontal" role="form">
							<input type="date" id="startDate" name="startDate"/>
								<input type="date" id="endDate" name="endDate"/>
						 <button type="submit" class="btn btn-primary">Refresh</button>
						  </form>
					</div>
					</div>
					<div class="portlet-body" >
					@foreach ($salesByMonth->groupBy('company') as $groupedByCompany)
						<table class="table table-condensed" id="table-production-execution-form" >
							<thead>
							<tr>
								<th>{{ $groupedByCompany->first()->company }}</th>
								<tr>
									<th>Cliente</th>
									@foreach($Month as $month)

										<th>{{ $month->date }}</th>
									@endforeach
								</tr>	
							</tr>

							</thead>
							<tbody id="QuantityPerSales">
								@foreach ($groupedByCompany->groupBy('customer') as $groupedByCustomer)
								<tr>
									<td>
									{{ $groupedByCustomer->first()->customer }}
									</td>
									 @foreach($Month as $month)
							
										<th>{{ $salesByMonth->where('company',$groupedByCompany->first()->company)
											->where('customer',$groupedByCustomer->first()->customer)
											->where('date',$month->date )
											->first()!=null? number_format($salesByMonth->where('company',$groupedByCompany->first()->company)
											->where('customer',$groupedByCustomer->first()->customer)
											->where('date',$month->date)->first()->SubTotalVat,0) : 0 }}</th>
									@endforeach

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
