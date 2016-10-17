@extends('../../master')
@section('title', 'Plantillas | CognitivoERP')
@section('Title', 'Plantillas')

@section('content')


<div class="input-group">
	<a href="{{ route('project_template.create') }}" title="" class="btn btn-primary">Crear Plantilla</a>
</div>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($template as $element)
		<tr>
			<td>{{ $element->name }}</td>
			<td >
			<a href="{{route('project_template.edit',$element->id_project_template )}}" class="btn btn-icon-only blue">
                                                                                <i class="glyphicon glyphicon-pencil"> </i>
                                                                            </a>

																																						{!! Form::open(array('route' => array('project_template.destroy', $element->id_project_template), 'method' => 'delete')) !!}
																																						<a  class=" btn btn-icon-only red"  >
																																						 <i class="glyphicon glyphicon-trash"></i>
																																				 </a>
																																				{!! Form::close() !!}


                        </td>
		</tr>
	@endforeach

	</tbody>
</table>
@stop
