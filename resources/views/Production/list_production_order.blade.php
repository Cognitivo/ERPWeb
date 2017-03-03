@extends('../../master')
@section('title', 'Ordenes De Trabajo | CognitivoERP')
@section('Title', 'Ordenes De Trabajo')

@section('content')



 @include('flash::message')

<div class="input-group">
	<a href="{{ route('production_order.create') }}" title="" class="btn btn-primary">Crear Orden Trabajo</a>
	<a href="" title="" class="btn btn-primary" data-toggle="modal" data-target="#gridSystemModal">Cargar Archivo Excel</a>
</div>

<table class="table table-hover">
	<thead>
		<tr>
			<th>OT</th>
			<th>Total</th>
			<th>Estado</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($order as $element)
	
		<tr>
			<td>{{ $element->work_number }}</td>
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



<div id="gridSystemModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Cargar Archivo Excel</h4>
      </div>
     	 <form action="{{url('store_file_production_order')}}" method="POST" role="form" class="form-horizontal" accept-charset="UTF-8", enctype="multipart/form-data">
      <div class="modal-body">
        
      	  {!! csrf_field() !!}
      	<div class="form-group">
      		<label for="" class="control-label col-md-3">Archivo</label>
      		<div class="col-md-7">
      			<input type="file" name="file" class="form-control" id="" placeholder="Input field">
      		</div>
      		
      	</div>
      
      	
      
      </div>
      <div class="modal-footer">

      	<button type="submit" class="btn btn-primary">Guardar</button>    
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       
      </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@stop

@section('scripts')
	<script type="text/javascript">
		$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
	</script>
@stop
