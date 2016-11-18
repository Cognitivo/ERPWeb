@extends('../../master')
@section('title', 'Ordenes De Trabajo | CognitivoERP')
@section('Title', 'Ordenes De Trabajo')

@section('content')



 @include('flash::message')

<div class="input-group">
	<a href="{{ route('production_order.create') }}" title="" class="btn btn-primary">Crear Orden Trabajo</a>
</div>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Total</th>
			<th>Estado</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($order as $element)
	
		<tr>
			<td>{{ $element->name }}</td>
			<td>

			@if ($element->productionOrderDetail()->get()->count())
			
					{{App\ProductionOrderDetail::TotalProductionOrder($element->id_production_order)}}
			@endif			
			
			</td>
			<td> 
			@if ($element->status == 2)
				Aprobado
			@elseif($element->status == 4)
			Terminado
			@else
			Pendiente	
			@endif 
			</td>
			<td>
				<a href="{{route('production_order.edit',$element->id_production_order )}}" class="btn btn-icon-only blue">
                	<i class="glyphicon glyphicon-pencil"> </i>
                </a>
								{!! Form::open(array('route' => array('production_order.destroy', $element->id_production_order), 'method' => 'delete','style'=>'display: inline;')) !!}
								<button type="submit" class="btn btn-icon-only red glyphicon glyphicon-trash "></button>
						{!! Form::close() !!}

						
						@if ($element->status == 1)
							 <a href="{{ url('approved_production_order',$element->id_production_order) }}" class="btn purple">
                <i class="fa fa-file-o"></i> Aprobar </a>
						@endif
               

            </td>


		</tr>
	@endforeach

	</tbody>
</table>
@stop

@section('scripts')
	<script type="text/javascript">
		$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
	</script>
@stop
