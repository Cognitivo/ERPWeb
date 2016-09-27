@extends('../../master')
@section('title', 'Ordenes De Trabajo | CognitivoERP')
@section('Title', 'Ordenes De Trabajo')

@section('content')


<div class="input-group">
	<a href="{{ route('production_order.create') }}" title="" class="btn btn-primary">Crear Orden Trabajo</a>
</div>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($order as $element)
		<tr>
			<td>{{ $element->name }}</td>
			<td> 
				<a href="{{route('production_order.edit',$element->id_production_order )}}" class="btn btn-icon-only blue">
                	<i class="glyphicon glyphicon-pencil"> </i>
                </a>
			
                <form action="{{ route('production_order.destroy',$element->id_production_order) }}" method="delete" accept-charset="utf-8" style="display: inline;">
                 	{!! csrf_field() !!}
                	 <button  class=" btn btn-delete red"  >
                    	<i class="glyphicon glyphicon-trash"></i>
                	</button>
                </form>
               
            </td>
		</tr>
	@endforeach
		
	</tbody>
</table>
@stop