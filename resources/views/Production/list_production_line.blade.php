@extends('../../master')
@section('title', 'Lines De Trabajo | CognitivoERP')
@section('Title', 'Lines De Trabajo')
@section('content')


 @include('flash::message')

<div class="input-group">
	<a href="{{ route('production_line.create') }}" title="" class="btn btn-primary">Crear Line Trabajo</a>
</div>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($line as $element)
		<tr>
			<td>{{ $element->name }}</td>
			<td>
				<a href="{{route('production_line.edit',$element->id_production_line )}}" class="btn btn-icon-only blue">

                	<i class="glyphicon glyphicon-pencil"> </i>
                </a>
								{!! Form::open(array('route' => array('production_line.destroy', $element->id_production_line), 'method' => 'delete')) !!}
				        <button type="submit" class="btn btn-icon-only red glyphicon glyphicon-trash "></button>
				    {!! Form::close() !!}


            </td>

		{{-- 			<i class="glyphicon glyphicon-pencil"> </i>
				</a>
				{!! Form::open(array('route' => array('production_line.destroy', $element->id_production_line), 'method' => 'delete')) !!}
				<button type="submit" class="btn btn-icon-only red glyphicon glyphicon-trash "></button>
				{!! Form::close() !!}
			</td> --}}

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
