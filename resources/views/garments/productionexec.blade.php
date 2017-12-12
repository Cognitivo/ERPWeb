@extends('../../master')
@section('title', 'Lines De Trabajo | CognitivoERP')
@section('Title', 'Lines De Trabajo')
@section('content')


 @include('flash::message')

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
			<td><a href="garmentsproductionexec/{{$element->id_production_order }}">{{ $element->name }}</a></td>
      <td>{{ $element->work_number }}</td>
		  <td><a href="garmentsproductionexec/{{$element->id_production_order }}">{{ $element->productionLine->name }}</a></td>

		</tr>
		@endforeach
	</tbody>
</table>
@stop
