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
			<td><a href="/curve/{{ $value['name'] }}/edit">{{ $value['name'] }}</a></td>
      @foreach ($value['size'] as $element=>$value)
      <td>{{ $value }}</a></td>
      @endforeach

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
