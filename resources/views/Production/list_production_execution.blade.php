@extends('master')
@section('title', 'Ejecuciones | CognitivoERP')
@section('Title', 'Ejecuciones')
@if(Session::has('message'))
<div class="alert alert-danger alert-dismissable" id="result">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	<p id="message">
		{{Session::get('message')}}
	</p>
</div>
@endif
@section('content')
<div class="col-md-12">
	<div class="portlet light ">
		<div class="portlet-title tabbable-line">
			<div class="caption caption-md">
				<i class="icon-globe theme-font hide"></i>
				<span class="caption-subject font-blue-madison bold uppercase">Ejecuciones</span>
			</div>
		</div>
		<div class="portlet-body">

		<table class="table table-condensed" id="table-production-execution">
      <thead>
        <tr>
          <th>Nº de O.T.</th>
          <th>Nombre</th>
          <th>Linea Produccion</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        
      </tbody>
    </table>

			{{-- @foreach ($execution as $item)
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						{{ $item->name }}
					</div>
					<div class="tools">
						@if ($item->status == 1)
						<span class="label label-sm label-success">Pending</span>
						@elseif ($item->status == 2)
						<span class="label label-sm label-success">Aprobado</span>
						@elseif ($item->status == 3)
						<span class="label label-sm label-success">InProcess</span>
						@elseif ($item->status == 4)
						<span class="label label-sm label-success">Executed</span>
						@elseif ($item->status == 5)
						<span class="label label-sm label-success">QA-check</span>
						@elseif ($item->status == 6)
						<span class="label label-sm label-success">Qa-rejected</span>
						@else
						<span class="label label-sm label-danger">Ejecutado</span>
						@endif
						<a href="javascript:;" class="expand" data-original-title="" title=""> </a>
						
					</div>
				</div>
				<div class="portlet-body" style="display: none;">
					<div class="row">
						<div class="col-md-3">Nombre</div>
						<div class="col-md-3">Cantidad Estimada</div>
						<div class="col-md-3">Cantidad Executed</div>
						<div class="col-md-3">Cost</div>
					</div>
					<form action="{{url('api/approve_execustion')}}" method="POST" role="form" class="form-horizontal" accept-charset="UTF-8", enctype="multipart/form-data">
						@foreach ($item->productionOrderDetail()->get() as $element)
						<div class="row">
							<div class="col-md-3"><h5>{{  isset($element->item->name)?$element->item->name:""  }}</h5></div>
							<div class="col-md-3"><h5>{{  intval($element->quantity)  }}</h5></div>
							<div class="col-md-3">
								<h5>
								@if(isset($element->ProductionExecutionDetail))
								<a href="#" class="quantity_execution" data-pk="{{$element->ProductionExecutionDetail->id_execution_detail}}">
									{{ isset($element->ProductionExecutionDetail->quantity) ? intval($element->ProductionExecutionDetail->quantity) : '0'  }}
								</a>
								@else
								 0
								@endif
							</h5>
						</div>
						<div class="col-md-3">
							<h5>
							@if(isset($element->ProductionExecutionDetail))
							<a href="#" class="quantity_execution" data-pk="{{$element->ProductionExecutionDetail->id_execution_detail}}">
								{{ isset($element->ProductionExecutionDetail->unit_cost) ? intval($element->ProductionExecutionDetail->unit_cost) : '0'  }}
							</a>
							@else
							 0
							@endif
						</h5>
					</div>
							@if ( isset($element->ProductionExecutionDetail))
							<div class="col-md-3"><h5>  <a href="{{route('production_execution.edit',$element->ProductionExecutionDetail)  }}">edit</a></h5></div>
							@endif
							@if ( isset($element->ProductionExecutionDetail))
							<div class="col-md-3">
								{!! csrf_field() !!}
								<input type="hidden" id="production" value="{{$item}}">
								<button type="submit" class="btn btn-primary">Aprobar</button>
							</div>
							@endif
						</div>
						@endforeach
					</form>
				</div>
				@endforeach --}}
			</div>
		</div>
	</div>
	@endsection
	@section('scripts')
	 <script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
   <script src="/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	
	$('#table-production-execution').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    "pagingType": "bootstrap_full_number",
    "pageLength": 50,
    ajax: {
    url: '/production_execution',
    type: "get",
    async : true
    },
    "order": []
    }).on('draw.dt', function(e) {
    confirmationButton(e)
    $('tr td:nth-child(5)').each(function() {
                $(this).addClass('actions')
            })
            $('tr td:nth-child(4)').each(function() {
                $(this).addClass('status')
            })
	})
	
	
    
 function confirmationButton(e) {
    //e.preventDefault(e)
    $('[data-toggle="confirmation"]').confirmation({
        onConfirm: function() {
        	var row = $(this).parents('tr')
           	var id = row.data('id')
           $.get('/finish_execution/' + id,function(result){
           	 row.find('td.status').html("")
            var td = row.find('td.status').append('Executado')
            var td = row.find('td.actions .btn-delete').remove()
           });
        },
        onCancel: function() {
            console.log("ko")
        }
    });
}
	</script>
	@stop
