@extends('../../master')
@section('title', 'Plantilla | CognitivoERP')
@section('Title', 'Plantilla')

@section('css')
	 <link href="{{ url() }}/assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
@stop

@section('content')



<div class="portlet light ">
	<div class="portlet-title">

	    <div class="actions">
	        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;"  id="add_task">
	            <i class="icon-cloud-upload"></i>
	        </a>
	        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" id="update_task" >
	            <i class="icon-wrench"></i>
	        </a>
	        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" id="remove_task" data-token="{{ csrf_token() }}">
	            <i class="icon-trash"></i>
	        </a>


	    </div>
	</div>
	<div class="row">
		 <div class="portlet-body form">
		 @if (isset($template))
		 	 {{--  <form class="form-horizontal" role="form" method="put" action="{{route('project_template.update',$template) }}"> --}}
		 	 {!! Form::model($template,['route' => ['project_template.update',$template], 'method'=>'put','class'=> 'form-horizontal']) !!}
		 @else
		 	  <form class="form-horizontal" role="form" method="post" action="{{route('project_template.store') }}">
		 @endif


		   {!! csrf_field() !!}

		<div class="col-md-6">
			 <div class="form-body">
	                <div class="form-group">
	                    <label class="col-md-3 control-label">
	                        Tipo de Trabajo
	                    </label>
	                    <div class="col-md-9">
	                      {{--   <input class="form-control" placeholder="Enter text" type="text" name="name"  />     --}}
	                        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Full Name']) !!}
	                    </div>
	                </div>




	                <div class="form-group">
	                    <label class="col-md-3 control-label">
	                        Tipo de Artículo
	                    </label>
	                    <div class="col-md-9">
	                     {!!  Form::select('type_item',['5'=>'Tarea','1'=>'Producto','2'=>'Materia Prima','3'=>'Servicio','4'=>'Activo Fijo','6'=>'Insumo','7'=>'Contrato Servicio'],null,['class'=> 'form-control' ,'id'=>'type_item']) !!}

	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-3 control-label">
	                        Artículo
	                    </label>
	                    <div class="col-md-9">
	                        <div class="input-icon">
	                            <i class="fa fa-bell-o">
	                            </i>
	                            <input class="form-control" placeholder="Left icon" type="text" id="item" name="item" />
	                            <input type="hidden" name="id_item" id="id_item" value="">
	                        </div>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-3 control-label">
	                       Cantidad
	                    </label>
	                    <div class="col-md-9">
	                         <input class="form-control" value="0" type="text" name="unit_value"  id="unit_value" />
	                    </div>
	                </div>

	            </div>
	            <div class="form-actions">
	                <div class="row">
	                    <div class="col-md-offset-3 col-md-9">
	                        <button class="btn green" type="submit">
	                            Submit
	                        </button>
	                        <button class="btn default" type="button">
	                            Cancel
	                        </button>
	                    </div>
	                </div>
	            </div>
		</div>

		<div class="col-md-6">
			<div class="portlet-title">

	         </div>
	        <div class="portlet-body">
	        @if (isset($template))
	        <input type="hidden" id="type_load" value="{{$template->id_project_template}}">
	                 <div id="jstree" class="tree-demo">

                      </div>
	                  @else
	                    <input type="hidden" id="type_load" value="#">
	                <div id="jstree" class="tree-demo" >

                   </div>
	                  @endif

			</div>
		</div>

		<input type="hidden" name="tree_save" id="tree_save">

	        {!! Form::close() !!}

	</div>
</div>


</div>
@stop

@section('scripts')
	<!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ url() }}/assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
     

       <script src="{{ url() }}/assets/pages/scripts/tree-view-template.js" type="text/javascript"></script>

@stop
