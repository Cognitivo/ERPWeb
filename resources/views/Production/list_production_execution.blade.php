@extends('../../master')
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

			@foreach ($execution as $item)
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">

						{{ $item->name }}


					</div>
					<div class="tools">
						@if ($item->status == 2)
						<span class="label label-sm label-success">Aprobado</span>
						@else
						<span class="label label-sm label-danger">Ejecutado</span>
						@endif
						<a href="javascript:;" class="expand" data-original-title="" title=""> </a>
						{{-- <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
						<a href="javascript:;" class="reload" data-original-title="" title=""> </a> --}}
						{{-- <a href="javascript:;" class="remove" data-original-title="" title=""> </a> --}}
					</div>
				</div>
				<div class="portlet-body" style="display: none;">
					<div class="row">
						<div class="col-md-6">Nombre</div>
						<div class="col-md-3">Cantidad Estimada</div>
							<div class="col-md-3">Cantidad Executed</div>

					</div>
					@foreach ($item->productionOrderDetail()->get() as $element)

					<div class="row">

						<div class="col-md-6"><h5>{{  $element->item->name  }}</h5></div>
						<div class="col-md-3"><h5>{{  $element->quantity  }}</h5></div>
						<div class="col-md-3"><h5>{{ isset($element->ProductionExecutionDetail->quantity) ? $element->ProductionExecutionDetail->quantity : '0'  }}</h5></div>
          	<div class="col-md-3"><h5>  <a href="{{route('production_execution.edit',$element->ProductionExecutionDetail)  }}" class="btn btn-icon-only blue"></a></h5></div>

					</div>
					@endforeach
				</div>
			</div>
			@endforeach


		</div>
	</div>
</div>
@endsection
@section('scripts')
@stop
