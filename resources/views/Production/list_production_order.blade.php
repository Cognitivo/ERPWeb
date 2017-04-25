@extends('../../master')
@section('title', 'Ordenes De Trabajo | CognitivoERP')
@section('Title', 'Ordenes De Trabajo')

@section('content')



 @include('flash::message')


<div class="portlet light ">
      <div class="portlet-title">
        <div class="caption font-dark">
         
          <a href="{{ route('production_order.create') }}" title="" class="btn btn-primary">Crear Orden Trabajo</a>
	<a href="" title="" class="btn btn-primary" data-toggle="modal" data-target="#gridSystemModal">Cargar Archivo Excel</a>
        </div>
        <div class="tools"> </div>
      </div>
      <div class="portlet-body">
        <table class="table table-condensed" id="table-production-order">
	<thead>
		<tr>
			<th>Nº de O.T.</th>
			<th>Nombre</th>
			<th>Estado</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
	

	</tbody>
</table>
       
      </div>
    </div>
  </div>




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
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

      </div>
        </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@stop

@section('scripts')
<script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
 <script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
	<script type="text/javascript">
		//$('div.alert').not('.alert-important').delay(3000).fadeOut(350);

		$(document).ready(function(e){
      //e.preventDedault()			 
      $('#table-production-order').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        "pagingType": "bootstrap_full_number",
        "pageLength": 50,
        ajax: {
            url: '/production_order',
          type: "get",
          async : true
        },
        "order": []
    })
		})
	
	</script>
@stop
