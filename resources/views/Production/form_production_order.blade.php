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
          {!! Form::textarea('address', isset($production_order->project)? \App\Contact::addressContact($production_order->project->contact->id_contact) :null, ['class'=>'form-control', 'placeholder'=>'Address Contact','rows'=>'3','id'=>'address_contact']) !!}
          @if (isset($production_order->project))
          {!! Form::hidden('geo_lat',$production_order->project->contact->geo_lat,['id'=>'geo_lat']) !!}
          {!! Form::hidden('geo_long',$production_order->project->contact->geo_long,['id'=>'geo_long']) !!}
          {!! Form::hidden('geo_longlat',$production_order->project->contact->geo_longlat,['id'=>'geo_longlat']) !!}
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
              {!! Form::text('work_number', null, ['class'=>'form-control']) !!}
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
                {!! Form::text('contact', isset($production_order->project)? $production_order->project->contact->name:null, ['class'=>'form-control', 'placeholder'=>'Full Name','id'=>'contact','required']) !!}
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
          <div class="form-group">
            <label class="col-md-3 control-label">
              Tipo Trabajo
            </label>
            <div class="col-md-9">
              <select name="id_project_template" class="form-control" required>
                @foreach ($templates as $key => $element)
                <option value="{{$key}}" {{isset($production_order)? $production_order->project->id_project_template == $key ? 'selected' : '' :''}}>
                  {{$element}}
                </option>
                @endforeach
                
              </select>
              @foreach ($templates as $key => $element)
              <input type="hidden" name="name_project_template[{{$key}}]" value="{{$element}}" />
              @endforeach
            </div>
          </div>
        </div>
        <div class="form-actions">
          <div class="row">
          @if ($production_order->productionOrderDetail()->first()->status != 2)
            <div class="col-md-offset-3 col-md-9">
              <button class="btn green" type="submit" id="send_production_order">
              Guardar
              </button>
              <a href="{{route('production_order.index')}}" class="btn default"> Cancelar</a>
            </div>
          @endif
            
          </div>
        </div>
        @if (isset($production_order))
          <div class="row">
          <!-- Button trigger modal -->
          <div class="form-group">
          <label class="col-md-1 control-label"></label>
          <div class="col-md-9">
          @if ($production_order->status != 2)
             <a href="javascript:;" class="btn btn-icon-only green" data-toggle="modal" data-target="#myModal" title="Adicionar Tarea">
            <i class="glyphicon glyphicon-plus"></i>
          </a>
          @endif
          </div>
             
          </div>
        
        </div>
        @endif
        
        <div class="row">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Cantidad</th>
                <th> Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($production_order_detail as $element)
              <tr>
                <td>{{ $element->name }}</td>
                <td>
                  @if (\App\Items::typeItem($element->id_item) == 5)
                  @if ($element->status != 2)
                   <a href="#" class="start_date"  data-pk="{{$element->id_order_detail}}" > {{$element->start_date_est}}</a>
                  @else
                   <a > {{$element->start_date_est}}</a>
                  @endif
                 
                  @endif
                  
                  
                </td>
                <td>
                  @if (\App\Items::typeItem($element->id_item) == 5)
                    @if ($element->status != 2)
                     <a href="#" class="end_date" data-pk="{{$element->id_order_detail}}"> {{$element->end_date_est}}</a>
                    @else
                     <a> {{$element->end_date_est}}</a>
                    @endif
                 
                  @endif
                  
                  
                </td>
                <td>
                @if ($element->status != 2)
                 <a href="#" class="quantity" data-pk="{{$element->id_order_detail}}">{{ intval($element->quantity) }}</a></td>
                    @else
                     <a>{{ intval($element->quantity) }}</a></td>
                    @endif
                 
                  <td>
                     @if ($element->status != 2)
                    <form action="/production_order_detail/{{$element->id_order_detail}}"  method= "post" style =" display : inline;">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="_method" value="DELETE">
                     <button type="submit" class="btn btn-sm btn-icon-only red glyphicon glyphicon-trash " style="height : 30px !important;"></button>
                </form>
                 @endif
                  </td>
                </tr>

                @endforeach
              </tbody>
            </table>
          </div>
          
          <input type="hidden" name="tree_save" id="tree_save">
          {!! Form::close() !!}
          
        </div>
      </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Adicionar Tarea</h4>
          </div>
          <div class="modal-body">
            @if (isset($production_order))
             <form action="/add_order_detail" method="POST" class="form-horizontal" role="form">
             {!! csrf_field() !!}
              <input type="hidden" name="id_production_order" value="{{$production_order->id_production_order}}">             
                <div class="form-group">
                  <label class="col-md-3 control-label">Padre</label>
                  <div class="col-md-9">

                    <select name="parent_id_order_detail" class="form-control" >
                      <option value=""> Seleccione </option>
                      @if($production_order_detail->count())
                      @foreach ($production_order_detail as $key => $element)
                          @if ($element->item->id_item_type == 5)
                            <option value="{{$element->id_order_detail}}"> {{$element->name}} </option>
                          @endif
                         
                      @endforeach
                      @endif
                    </select>
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
                        {{--   <input class="form-control" placeholder="Enter text" type="text" name="name"  />     --}}
                          {!! Form::text('quantity', null, ['class'=>'form-control', 'placeholder'=>'Cantidad']) !!}
                      </div>
                  </div>
            
                <div class="form-group">
                  <div class="col-sm-10 col-sm-offset-2">
                  
                  </div>
                </div>
           
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Adicionar</button>
          </div>
          </form>
            @endif
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
    /*
    var id_project_id_project_template = $('#id_project option:selected').val()
    var id_project = id_project_id_project_template.split("-")[0]
    var id_project_template= id_project_id_project_template.split("-")[1]*/
    //$('#link_template').click(function(){
    //console.log($('#jstree1').jstree())
    /*var id_project_id_project_template = $('#id_project option:selected').val()
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
    })*/
    </script>
    
    
    @stop