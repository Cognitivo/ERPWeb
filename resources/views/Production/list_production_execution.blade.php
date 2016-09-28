@extends('../../master')

@section('title', 'work | CognitivoERP')
@section('Title', 'Work Form')
@section('css')
	 <link href="{{ url() }}/assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
@stop
 @if(Session::has('message'))
<div class="alert alert-danger alert-dismissable" id="result">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <p id="message">

        {{Session::get('message')}}

    </p>

</div>
@endif
@section('content')


<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                <!-- PORTLET MAIN -->
                <div class="portlet light profile-sidebar-portlet ">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                        <img src="../assets/pages/media/profile/profile_user.jpg" class="img-responsive" alt="">
                    </div>
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">'contacts' </div>
                        <div class="profile-usertitle-job"> 'contacts' </div>
                    </div>
                    <div class="profile-userbuttons">
                        <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                        <button type="button" class="btn btn-circle red btn-sm">Message</button>
                    </div>
                </div>
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Work</span>
                                </div>
                            </div>
                            <div class="portlet-body">


                              <div id="tree_1" class="tree-demo">
                                  <ul>
                                      <li id="name_parent">
                                          <ul>
                                              <li data-jstree='{ "selected" : true }'>
                                                  <a href="javascript:;" id="name_contact">  </a>
                                              </li>

                                          </ul>
                                      </li>

                                  </ul>
                              </div>

                                <div class="tabbable-custom nav-justified">
                                    <ul class="nav nav-tabs nav-justified">
                                        <li class="active"><a href="#tab_1_1_1" data-toggle="tab">Producto</a></li>
                                        <li><a href="#tab_1_1_2" data-toggle="tab">Mat.Prima</a></li>
                                        <li><a href="#tab_1_1_3" data-toggle="tab">Servicia</a></li>
                                        <li><a href="#tab_1_1_4" data-toggle="tab">Activo Fijo</a></li>
                                        <li><a href="#tab_1_1_5" data-toggle="tab">Insumos</a></li>
                                        <li><a href="#tab_1_1_6" data-toggle="tab">Serv.Contr</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1_1_1">
                                            <div class="form-group">
                                                <label for="cantidad" class="control-label">Cantidad EJC</label>
                                                <div >
                                                    <input type="text" class="form-control" id="cantidad" placeholder="Quantity">
                                                </div>
                                            </div>
                                            <div class="portlet box blue">
                                                <div class="portlet-title">
                                                    <div class="caption">Table</div>
                                                    <div class="tools">
                                                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                                        <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
                                                        <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
                                                        <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nombre</th>
                                                                    <th>Cantidad</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Cable de acero</td>
                                                                    <td>25</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane" id="tab_1_1_2">
                                            <p>I'm in Section 2. </p>
                                        </div>
                                        <div class="tab-pane" id="tab_1_1_3">
                                            <div class="form-group">
                                                <label class="control-label ">Fecha inicio</label>
                                                <div >
                                                    <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="" />
                                                </div>
                                                <div >
                                                    <div class="input-icon">
                                                        <i class="fa fa-clock-o"></i>
                                                        <input type="text" class="form-control timepicker timepicker-default">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label">Fecha fin</label>
                                                <div >
                                                    <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="" />
                                                </div>
                                                <div >
                                                    <div class="input-icon "  >
                                                        <i class="fa fa-clock-o"></i>
                                                        <input type="text" class="form-control timepicker timepicker-default " >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class=" control-label">Empleado</label>
                                                <div >
                                                    <input type="text" class="form-control" placeholder="Employee">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class=" control-label">Coeficiente</label>
                                                <div >
                                                    <select class="form-control">
                                                        <option>50%</option>
                                                        <option>70%</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="portlet box blue">
                                                <div class="portlet-title">
                                                    <div class="caption">Table</div>
                                                    <div class="tools">
                                                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                                        <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
                                                        <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
                                                        <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nombre</th>
                                                                    <th>Fecha inicio</th>
                                                                    <th>Fecha fin</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Fecha inicio</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Cable de acero</td>
                                                                    <td>25/01/2016</td>
                                                                    <td>25/02/2016</td>
                                                                    <td>1</td>
                                                                    <td>1.5</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane" id="tab_1_1_4"><p>I'm in Section 4.</p></div>
                                        <div class="tab-pane" id="tab_1_1_5"><p>I'm in Section 5.</p></div>
                                        <div class="tab-pane" id="tab_1_1_6"><p>I'm in Section 6. </p></div>
                                    </div>
                                </div>
                                <div class="margiv-top-10">
                                    {!! Form::submit( 'GUARDAR CAMBIOS', ['class'=>'btn green']) !!}
                                    <a href="javascript:;" class="btn default"> CANCELAR</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
	<!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ url() }}/assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->



 {{--        <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJ_Pf9r3W4LqU71Br79LK8pFDD6nrfXRU&callback=initMap">
    </script> --}}

         <script src="http://maps.google.com/maps/api/js?key=AIzaSyAJ_Pf9r3W4LqU71Br79LK8pFDD6nrfXRU" type="text/javascript"></script>
        <script src="../assets/global/plugins/gmaps/gmaps.min.js" type="text/javascript"></script>



           <script src="{{ url() }}/assets/pages/scripts/tree-view-template.js" type="text/javascript"></script>



       <script type="text/javascript">

		$('#link_template').click(function(){
              //console.log($('#jstree1').jstree())
              var id_project_id_project_template = $('#id_project option:selected').val()
              var id_project_template= id_project_id_project_template.split("-")[1]

           load_tree_project_order(id_project_template)

		})


	</script>
                    @endsection
