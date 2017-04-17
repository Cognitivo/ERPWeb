@extends('master')
@section('title', 'Order Trabajo | CognitivoERP')
@section('Title', 'Orden Trabajo')
@section('css')
<link href="{{ url() }}/assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
@stop
@section('content')
<div class="row">
  <div class="col-md-4">
    <div class="portlet light ">
      <div class="portlet-title">
        <div class="actions">

        </div>
        <div class="portlet-body">
          <div id="tree_1" class="tree-demo">
            <ul>
              <li id="name_parent">
                <ul>
                  <li data-jstree='{ "selected" : true }'>
                    <a href="javascript:;" id="name_contact"> </a>
                  </li>

                </ul>
              </li>

            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="portlet light portlet-fit ">
      <div class="portlet-title">
        <div class="caption">
          <i class=" icon-layers font-green"></i>
          <span class="caption-subject font-green bold uppercase">Localización Contacto</span>
        </div>
        <div class="actions">

        </div>
      </div>
      <div class="portlet-body">
        <div class="form-group">


          {!! Form::textarea('address', isset($production_order->project)? $production_order->project->contact->address:null, ['class'=>'form-control', 'placeholder'=>'Address Contact','rows'=>'3','id'=>'address_contact']) !!}
          @if (isset($production_order->project))
          {!! Form::hidden('geo_lat',$production_order->project->contact->geo_lat,['id'=>'geo_lat']) !!}
          {!! Form::hidden('geo_long',$production_order->project->contact->geo_long,['id'=>'geo_long']) !!}
          @endif

        </div>
        <div class="label label-danger visible-ie8"> Not supported in Internet Explorer 8 </div>
        <div id="gmap_geo" class="gmaps"> </div>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="portlet light ">
      <div class="portlet-body form">
        @if (isset($production_order))
        <input type="hidden" name="" id="id_production_order" value="{{ $production_order->id_production_order }}">
        {!! Form::model($production_order,['route' => ['production_order.update',$production_order], 'method'=>'put','class'=> 'form-horizontal']) !!}
        @else

        {!! Form::open(['route'=>'production_order.store','class'=>'form-horizontal' ,'role'=>'form','method'=>'post']) !!}
        @endif
        {!! csrf_field() !!}

        <div class="form-body">
          <div class="form-group">
            <label class="control-label col-md-3">Número OT</label>
            <div class="col-md-9">
              <p class="form-control-static"> {{isset($production_order) ? $production_order->work_number : ""}} </p>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">
              Contacto
            </label>
            <div class="col-md-9">
              <div class="input-icon">
                <i class="fa fa-bell-o">
                </i>
                {!! Form::text('contact', isset($production_order->project)?$production_order->project->contact->name:null, ['class'=>'form-control', 'placeholder'=>'Full Name','id'=>'contact']) !!}
                {!! Form::hidden('id_contact',isset($production_order->project)?$production_order->project->contact->id_contact:null,['id'=>'id_contact']) !!}
                {!! Form::hidden('parent_name_contact',isset($production_order->project)?!is_null($production_order->project->contact->parentContact)?$production_order->project->contact->parentContact->name:null:null,['id'=>'parent_name_contact']) !!}


              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">
              Reclamo
            </label>
            <div class="col-md-9">
              {{--   <input class="form-control" placeholder="Enter text" type="text" name="name"  />     --}}
              {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Full Name']) !!}
            </div>
          </div>
          {{--  <div class="form-group">
            <label class="col-md-3 control-label">
              Area
            </label>
            <div class="col-md-9">
              {!!  Form::select('type_item',$project_tags,null,['class'=> 'form-control' ,'id'=>'type_item']) !!}
            </div>
          </div> --}}
          <div class="form-group">
            <label class="control-label col-md-3">Rango de Fecha</label>
            <div class="col-md-9">
              <div class="input-group defaultrange" >

                {!! Form::text('range_date',isset($production_order)?$production_order->start_date_est."-".$production_order->end_date_est:null,['class'=>'form-control','readonly','required']) !!}
                <span class="input-group-btn">
                  <button class="btn default date-range-toggle" type="button">
                  <i class="fa fa-calendar"></i>
                  </button>
                </span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label">
              Linea de Producción
            </label>
            <div class="col-md-9">
              {!!  Form::select('id_production_line',$production_line,null,['class'=> 'form-control' ,'id'=>'id_production_line']) !!}
            </div>
          </div>

        </div>
        <div class="form-actions">
          <div class="row">
            <div class="col-md-offset-3 col-md-9">
              <button class="btn green" type="submit" id="send_production_order">
              Submit
              </button>
             <a href="{{route('production_order.index')}}" class="btn default"> CANCELAR</a>
            </div>
          </div>
        </div>
        <table class="table table-hover">
        	<thead>
        		<tr>

        			<th>Name</th>
        			<th>Estado</th>
            	<th>Cantidad</th>

        		</tr>
        	</thead>
        	<tbody>
        	@foreach ($production_order_detail as $element)

        		<tr>
        			<td>{{ $element->name }}</td>
        			<td>
        			@if ($element->status == 2)
        				Aprobado
        			@elseif($element->status == 4)
        			Terminado
        			@else
        			Pendiente
        			@endif
        			</td>
              	<td>{{ $element->quantity }}</td>
                <td>
                <a href="{{route('production_order_detail.edit',$element->id_order_detail )}}" class="btn btn-icon-only blue">
                          <i class="glyphicon glyphicon-pencil"> </i>
                        </a>
</td>

        		</tr>
        	@endforeach

        	</tbody>
        </table>



        <input type="hidden" name="tree_save" id="tree_save">

        {!! Form::close() !!}
        <div class="form-group">
         <label class="col-md-3 control-label">
           Tipo Trabajo
         </label>
         <div class="col-md-9">
           <div class="input-group">
             <form action="{{url('store_template_production_order')}}" method="POST" role="form" class="form-horizontal" accept-charset="UTF-8", enctype="multipart/form-data">
                 {!! csrf_field() !!}
                 {!!  Form::select('id_project_template',$templates,null,['class'=> 'form-control' ,'id'=>'id_project_template']) !!}
              <button type="submit" class="btn btn-primary">Generate Template</button>

              </form>


         <!--    <span class="input-group-addon">
               <a  data-target="#load_template" data-toggle="modal" id="link_template" title="asignar cantidades">
                 Asignar Cantidades
               </a>

             </span>-->
         </div>
         </div>
         <input type="hidden" name="name" id="name_production_order">
       </div>

      </div>
    </div>
  </div>

  <!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->
  <div class="modal fade" id="load_template" role="basic" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-full">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Asignar Cantidades</h4>
        </div>
        <div class="modal-body" id="modal_template">
          <div class="actions pull-right">
            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;"  id="add_task_production_order" title="Añadir">
              <i class="icon-cloud-upload"></i>
            </a>
            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" id="update_task_production_order" data-token="{{ csrf_token() }}" title="Editar">
              <i class="fa fa-edit"></i>
            </a>
            <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" id="remove_task" data-token="{{ csrf_token() }}" title="Eliminar">
              <i class="icon-trash"></i>
            </a>
          </div>
          <div class="scroller" style="height:500px" data-always-visible="1" data-rail-visible1="1">
            <div class="row">
              <div class="col-md-4">
                <h4>Tareas</h4>

              </div>
              <div class="col-md-8">

                <div id='jstree' class='tree-demo' ></div>
              </div>
            </div>
          </div>




        </div>
        <div class="modal-footer">
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">Guardar</button>

        </div>

      </div>
    </div>
  </div>

  @stop
  @section('scripts')
  <!-- BEGIN PAGE LEVEL PLUGINS -->
  <script src="{{ url() }}/assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL PLUGINS -->

  {{--        <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJ_Pf9r3W4LqU71Br79LK8pFDD6nrfXRU&callback=initMap">
  </script> --}}

  <script src="http://maps.google.com/maps/api/js?key=AIzaSyAJ_Pf9r3W4LqU71Br79LK8pFDD6nrfXRU" type="text/javascript"></script>
  <script src="{{ url() }}/assets/global/plugins/gmaps/gmaps.min.js" type="text/javascript"></script>


  <script src="{{ url() }}/assets/pages/scripts/tree-view-template.js" type="text/javascript"></script>

  <script type="text/javascript">

  var id_project_id_project_template = $('#id_project option:selected').val()
  var id_project = id_project_id_project_template.split("-")[0]
  var id_project_template= id_project_id_project_template.split("-")[1]

  $('#link_template').click(function(){
  //console.log($('#jstree1').jstree())

  var id_project_id_project_template = $('#id_project option:selected').val()
  var id_project = id_project_id_project_template.split("-")[0]
  var id_project_template= id_project_id_project_template.split("-")[1]
  load_tree_project_order(id_project_template,id_project)

  })
  $(document).ready(function(){
  var name_project= $('#id_project option:selected').text()
  get_name_project(name_project)
  if($('#id_production_order').val()!=undefined){
  load_tree_project_order(id_project_template,id_project)
  }
  })
  $('#send_production_order').click(function(){
  var objtree = $('#jstree').jstree(true).get_json('#', {
  flat: true
  })
  var fulltree = JSON.stringify(objtree);
  console.log(fulltree)
  $('#tree_save').val(fulltree)
  })
  </script>
  @stop
