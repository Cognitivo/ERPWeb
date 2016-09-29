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

@if(isset($line))
{!! Form::model($line,['route' => ['production_line.update',$line->id_production_line], 'method'=>'put']) !!}
@else
    {!! Form::open(array('route'=> 'production_line.store','class'=>'form-horizontal')) !!}
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
                        <img src="../assets/pages/media/profile/profile_user.jpg" class="img-responsive" alt=""> </div>
                        <!-- END SIDEBAR USERPIC -->
                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">'contacts' </div>
                            <div class="profile-usertitle-job"> 'contacts' </div>
                        </div>

                        <!-- END SIDEBAR USER TITLE -->
                        <!-- SIDEBAR BUTTONS -->
                        <div class="profile-userbuttons">
                            <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                            <button type="button" class="btn btn-circle red btn-sm">Message</button>
                        </div>
                        <!-- END SIDEBAR BUTTONS -->
                        <!-- SIDEBAR MENU -->

                            <!-- END MENU -->
                        </div>
                        <!-- END PORTLET MAIN -->
                        <!-- PORTLET MAIN -->
                        <div class="portlet light ">
                            <!-- STAT -->

                            <!-- END STAT -->
                            <div>
                                <!-- <h4 class="profile-desc-title">About Marcus Doe</h4>
                                <span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
                                <div class="margin-top-20 profile-desc-link">
                                <i class="fa fa-globe"></i>
                                <a href="http://www.keenthemes.com">www.keenthemes.com</a>
                            </div>
                            <div class="margin-top-20 profile-desc-link">
                            <i class="fa fa-twitter"></i>
                            <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                        <i class="fa fa-facebook"></i>
                        <a href="http://www.facebook.com/keenthemes/">keenthemes</a>
                    </div> -->
                </div>
            </div>
            <!-- END PORTLET MAIN -->
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
                          <div class="form-group  margin-top-20">
                              <label class="control-label col-md-2">Nombre
                                  <span class="required"> * </span>
                              </label>
                          <div class="col-md-4">
                              <div class="input-icon right">
                                  <i class="fa"></i>
                                {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Line Name']) !!}
                                 </div>
                          </div>
                        </div>
                        <div class="form-group">
                                         <label class="control-label col-md-2">Ubicacion
                                             <span class="required"> * </span>
                                         </label>
                                         <div class="col-md-4">
                                            {!!  Form::select('id_location',$applocation,null,['class'=> 'form-control' ,'required']) !!}
                                         </div>
                                     </div>

                                     <div class="margiv-top-10">
                                         {!! Form::submit( 'GUARDAR CAMBIOS', ['class'=>'btn green']) !!}
                                         <a href="{{route('production_line.index')}}" class="btn default"> CANCELAR</a>
                                     </div>

                    </div>
                    <!-- END PAGE CONTENT INNER -->
                    @endsection
