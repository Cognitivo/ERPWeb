@extends('../../master')
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
					 @if (isset($production_order))
				 	<input type="hidden" id="type_load" value="{{$production_order->id_production_order}}">
				 					 <div id="jstree" class="tree-demo">

				 							</div>
				 						@else
				 							<input type="hidden" id="type_load" value="#">
				 					<div id="jstree" class="tree-demo" >

				 					 </div>
				 						@endif
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


                {!! Form::textarea('address', isset($production_order)?isset($production_order->project)?$production_order->project->contact->address:null:null, ['class'=>'form-control', 'placeholder'=>'Address Contact','rows'=>'3','id'=>'address_contact']) !!}

                @if (isset($production_order))
								@if(isset($production_order->project))
                    {!! Form::hidden('geo_lat',$production_order->project->contact->geo_lat,['id'=>'geo_lat']) !!}
                    {!! Form::hidden('geo_long',$production_order->project->contact->geo_long,['id'=>'geo_long']) !!}
                @endif
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
                                <p class="form-control-static">  </p>
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

                                     {!! Form::text('contact', isset($production_order)?isset($production_order->project)?$production_order->project->contact->name:null:null, ['class'=>'form-control', 'placeholder'=>'Full Name','id'=>'contact']) !!}

                                     {!! Form::hidden('id_contact',isset($production_order)?isset($production_order->project)?$production_order->project->contact->id_contact:null:null,['id'=>'id_contact']) !!}
																		  {!! Form::hidden('parent_name_contact',isset($production_order)?!is_null(isset($production_order->project)?$production_order->project->contact->parentContact:null)?$production_order->project->contact->parentContact->name:null:null,['id'=>'parent_name_contact']) !!}



                                </div>
                            </div>
                        </div>

                             <div class="form-group">
                        <label class="col-md-3 control-label">
                            Reclamo
                        </label>
                        <div class="col-md-9">
                          {{--   <input class="form-control" placeholder="Enter text" type="text" name="name"  />     --}}
                            {!! Form::text('name', $name, ['class'=>'form-control', 'placeholder'=>'Full Name','id'=>'name']) !!}
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

                         <div class="input-group">
                            {!!  Form::select('id_project',$templates,isset($production_order)?isset($production_order->project)?$production_order->project->id_project."-".$production_order->project->id_project_template:null:null,['class'=> 'form-control' ,'id'=>'id_project']) !!}
                            <span class="input-group-addon">
                            <a  data-target="#load_template" data-toggle="modal" id="link_template" title="asignar cantidades">
                                 <i class="fa fa-user"></i>
                            </a>

                            </span>
                        </div>

                        </div>

                        <input type="hidden" name="name" id="name_production_order">
                        </div>
             </div>


                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="btn green" type="submit" id="send_production_order">
                                Submit
                            </button>
                            <button class="btn default" type="button">
                                Cancel
                            </button>
                        </div>
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



 {{--        <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJ_Pf9r3W4LqU71Br79LK8pFDD6nrfXRU&callback=initMap">
    </script> --}}

         <script src="http://maps.google.com/maps/api/js?key=AIzaSyAJ_Pf9r3W4LqU71Br79LK8pFDD6nrfXRU" type="text/javascript"></script>
        <script src="{{ url() }}/assets/global/plugins/gmaps/gmaps.min.js" type="text/javascript"></script>



           <script src="{{ url() }}/assets/pages/scripts/tree-view-order.js" type="text/javascript"></script>





@stop
