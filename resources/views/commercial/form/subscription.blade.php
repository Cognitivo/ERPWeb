@extends('../../master')

@section('title', 'Contacts | CognitivoERP')
@section('Title', 'subscription')

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
                        <img src="../assets/pages/media/profile/profile_user.jpg" class="img-responsive" alt=""> </div>
                        <!-- END SIDEBAR USERPIC -->
                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">  </div>
                            <div class="profile-usertitle-job">  </div>
                        </div>
                        <!-- END SIDEBAR USER TITLE -->
                        <!-- SIDEBAR BUTTONS -->
                        <div class="profile-userbuttons">
                            <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                            <button type="button" class="btn btn-circle red btn-sm">Message</button>
                        </div>
                        <!-- END SIDEBAR BUTTONS -->
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="active">
                                    <a href="#">
                                        <i class="icon-user"></i> Overview </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- END MENU -->
                        </div>
                        <!-- END PORTLET MAIN -->
                        <!-- PORTLET MAIN -->
                        <div class="portlet light ">
                            <!-- STAT -->
                            <div class="row list-separated profile-stat">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title"> 37 </div>
                                    <div class="uppercase profile-stat-text"> Projects </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title"> 51 </div>
                                    <div class="uppercase profile-stat-text"> Tasks </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <div class="uppercase profile-stat-title"> 61 </div>
                                    <div class="uppercase profile-stat-text"> Uploads </div>
                                </div>
                            </div>
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
                                <span class="caption-subject font-blue-madison bold uppercase">Subscription</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_1" data-toggle="tab">Information</a>
                                </li>

                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane active" id="tab_1_1">
                                  
@if (isset($contact_subscription))
   {!! Form::model($contact_subscription,['route' => ['subscription.update',$contact_subscription->id_subscription], 'method'=>'put']) !!}
@else
    {!! Form::open(array('route'=> 'subscription.store','class'=>'form-horizontal')) !!}
@endif


{!! csrf_field() !!}

                                               

                                      <div class="form-group">
                                            <label class="control-label">Name</label>
                                            @if (isset($contact_subscription))
                                               {!! Form::text('id_contact',  $contact_subscription->Contacts->name."\t".$contact_subscription->id_contact, ['id'=>'example-ajax-post','class'=>'form-control', 'placeholder'=>'Full Name']) !!}
                                            @else
                                              {!! Form::text('id_contact', null, ['id'=>'example-ajax-post','class'=>'form-control', 'placeholder'=>'Full Name']) !!}
                                            @endif
                                            
                                        </div>
                                          <div class="form-group">
                                            <label class="control-label">Plan</label>
                                            @if (isset($contact_subscription))
                                                {!! Form::text('id_item', $contact_subscription->Items->name."\t".$contact_subscription->id_item , ['id'=>'example-ajax-post1','class'=>'form-control', 'placeholder'=>'Full Name']) !!}
                                            @else
                                                {!! Form::text('id_item', null, ['id'=>'example-ajax-post1','class'=>'form-control', 'placeholder'=>'Full Name']) !!}
                                            @endif
                                            
                                        </div>
                                      <div class="form-group">
                                          <label class="control-label">Start Date</label>
                                          {!! Form::date('start_date', null, ['class'=>'form-control col-md-7 col-xs-12', 'placeholder'=>'Start Date']) !!}
                                      </div>
                                      <div class="form-group">
                                          <label class="control-label">End Date</label>
                                          {!! Form::date('end_date', null, ['class'=>'form-control', 'placeholder'=>'End Date']) !!}
                                      </div>
                                        <div class="form-group">
                                            <label class="control-label">Unit Price</label>
                                            {!! Form::text('unit_price', null, ['class'=>'form-control', 'placeholder'=>'Full Name']) !!}
                                        </div>

                                        <div class="margiv-top-10">
                                            {!! Form::submit( 'Save Changes', ['class'=>'btn green']) !!}
                                            <a href="javascript:;" class="btn default"> Cancel </a>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                                
                                <!-- END PERSONAL INFO TAB -->
                                <!-- CHANGE AVATAR TAB -->
                                <div class="tab-pane" id="tab_1_2">

                                </div>


                                <!-- END PROFILE CONTENT -->
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT INNER -->

                    

                    @endsection


@section('pagescripts')


    <script type="text/javascript">
        
    $(document).ready(function() {
        contacts()
        plan()
    });

        function contacts(){
    var options = {

        url: function(phrase) {
            var frase= $("#example-ajax-post").val();
            return "/get_contacts/?query="+frase;
        },

        getValue: function(element) {

            return element.name +"\t"+element.id_contact
        },
        list: {
            match: {
                enabled: true
            },
       
            maxNumberOfElements: 8


        },

        ajaxSettings: {
            dataType: "json",
            method: "get",
            data: {
                dataType: "json"
            }
        },

        ajaxSettings: {
        dataType: "json",
            method: "get",
            data: {
            dataType: "json"
        }
    },

        preparePostData: function(data) {
            data.phrase = $("#example-ajax-post").val();

            return data;


        },

        requestDelay: 500
        //theme: "square"
    };

    $("#example-ajax-post").easyAutocomplete(options);
}


function plan(){
    var options = {

        url: function(phrase) {
            var frase= $("#example-ajax-post1").val();
            return "/get_plan/?query="+frase;
        },

        getValue: function(element) {

            return element.name +"\t"+element.id_item
        },
        list: {
            match: {
                enabled: true
            },
       
            maxNumberOfElements: 8


        },

        ajaxSettings: {
            dataType: "json",
            method: "get",
            data: {
                dataType: "json"
            }
        },

        ajaxSettings: {
        dataType: "json",
            method: "get",
            data: {
            dataType: "json"
        }
    },

        preparePostData: function(data) {
            data.phrase = $("#example-ajax-post1").val();

            return data;


        },

        requestDelay: 500
        //theme: "square"
    };

    $("#example-ajax-post1").easyAutocomplete(options);
}
    </script>
@stop