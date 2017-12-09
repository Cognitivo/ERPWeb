@extends('../../master')
@section('title', 'Lines De Trabajo | CognitivoERP')
@section('Title', 'Lines De Trabajo')
@section('content')


 @include('flash::message')

<div class="input-group">
	<a href="{{ route('garmentsproduction.create') }}" title="" class="btn btn-primary">Crear Production</a>
</div>
<table class="table table-hover">
	<thead>
		<tr>
      <th>Nº de O.T.</th>
      <th>Nombre</th>
      <th>Linea Produccion</th>

		</tr>
	</thead>
	<tbody>
		@foreach ($productions as $element)
		<tr>
			<td>{{ $element->name }}</td>
      <td>{{ $element->work_number }}</td>
		  <td>{{ $element->productionLine->name }}</td>

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
