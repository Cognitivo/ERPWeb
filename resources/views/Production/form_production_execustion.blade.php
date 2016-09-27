@extends('../../master')

@section('title', 'work | CognitivoERP')
@section('Title', 'Work Form')

 @if(Session::has('message'))
<div class="alert alert-danger alert-dismissable" id="result">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
   <p id="message">

   {{Session::get('message')}}

   </p>

</div>
@endif
@section('content')

@if(isset($contacts))
{!! Form::model($contacts,['route' => ['contacts.update',$contacts->id_contact], 'method'=>'put']) !!}
@else
    {!! Form::open(array('route'=> 'contacts.store','class'=>'form-horizontal')) !!}
@endif


{!! csrf_field() !!}
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
          <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
          <div class="tab-pane active" id="orden de trabajo">
            <div class="form-group">
              <div class="form-group  margin-top-20">
                <label class="control-label col-md-3">Orden De Trabajo</label>
                <div class="col-md-4">
                    <div class="input-icon right">
                        <i class="fa"></i>
                        <input type="text" class="form-control" name="name" placeholder="Work Order"/>
                    </div>
                </div>
              </div>
            </div>
          <div class="form-group">
            <div class="form-group">
              <label class="control-label col-md-3">Equipo Trabajo</label>
              <div class="col-md-4">
                <div class="input-icon right">
                  <i class="fa"></i>
                  <input type="text" class="form-control" name="name" placeholder="Team Work"/>
                </div>
              </div>
            </div>
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
                  <label for="cantidad" class="col-md-2 control-label">Cantidad EJC</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="cantidad" placeholder="Quantity"> </div>
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
                  <div class="form-group">
                    <label class="col-md-2 control-label">Commentario</label>
                    <div class="col-md-6">
                      <textarea class="form-control" rows="3"></textarea>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="tab_1_1_2">
                  <p>I'm in Section 2. </p>
                </div>
              <div class="tab-pane" id="tab_1_1_3">
                <div class="form-group">
                  <label class="control-label col-md-3">Fecha inicio</label>
                  <div class="col-md-3">
                    <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="" />
                  </div>
                  <div class="col-md-3">
                    <div class="input-icon">
                      <i class="fa fa-clock-o"></i>
                      <input type="text" class="form-control timepicker timepicker-default">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3">Fecha fin</label>
                  <div class="col-md-3">
                      <input class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="" />
                  </div>
                  <div class="col-md-3">
                    <div class="input-icon">
                      <i class="fa fa-clock-o"></i>
                      <input type="text" class="form-control timepicker timepicker-default">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-3 control-label">Empleado</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" placeholder="Employee">
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
              <div class="form-group">
                <label class="col-md-3 control-label">Coeficiente</label>
                <div class="col-md-2">
                  <select class="form-control">
                    <option>50%</option>
                    <option>70%</option>
                  </select>
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
      @endsection
