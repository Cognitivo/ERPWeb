@extends('../../master')
@section('title', 'Curve | CognitivoERP')
@section('Title', 'Curve')
@section('content')


 @include('flash::message')

<div class="input-group">
	<a href="/curve/create" title="" class="btn btn-primary">Crear Curve</a>
</div>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Size</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($Json as $element=>$value)
		<tr>
			<td>{{ $value['name'] }}</td>
            <td>	<a href="/curve/{{ $value['name'] }}/edit">{{ $value['size'] }}</a></td>


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
