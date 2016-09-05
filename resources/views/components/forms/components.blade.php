@extends('../../master')

@section('title', 'Components | CognitivoERP')
@section('Title', 'Components Form')

@section('content')

{!! Form::open(array('url'=> 'createcomponent','class'=>'form-horizontal')) !!}

{!! csrf_field() !!}
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Component</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane active" id="tab_1_1">
                                    <form role="form" action="#">
                                      <div class="form-group">
                                          <label class="control-label">Name</label>
                                          {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Name Of The Component']) !!}
                                      </div>
                                      <div class="form-group">
                                          <label class="control-label">Type</label>
                                            <div class="md-radio-inline">
                                                <div class="md-radio">
                                                    <input type="radio" id="radio6" name="type" class="md-radiobtn" value="kpi">
                                                    <label for="radio6">
                                                        <span class="inc"></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Kpi </label>
                                                </div>
                                                <div class="md-radio">
                                                    <input type="radio" id="radio7" name="type" class="md-radiobtn" value="BarChart">
                                                    <label for="radio7">
                                                        <span class="inc"></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Bar Chart </label>
                                                </div>
                                                <div class="md-radio">
                                                    <input type="radio" id="radio8" name="type" class="md-radiobtn" value="PieChart">
                                                    <label for="radio8">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Pie Chart </label>
                                                </div>
                                            </div>
                                      </div>

                                        <div class="form-group">
                                            <label class="control-label">Unit</label>
                                            {!! Form::text('unit', null, ['class'=>'form-control', 'placeholder'=>'Unit Of The Result']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Module</label>
                                            {!! Form::text('module', null, ['class'=>'form-control', 'placeholder'=>' Access Module']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Description</label>
                                            {!! Form::text('description', null, ['class'=>'form-control']) !!}
                                        </div><div class="form-group">
                                            <label class="control-label">Query</label>
                                            {!! Form::textarea('query', null, ['class'=>'form-control', 'rows'=>'3', 'placeholder'=>'Query of the Component']) !!}
                                        </div>
                                        <div class="margiv-top-10">
                                            {!! Form::submit( 'Save Changes', ['class'=>'btn green']) !!}
                                            <a href="javascript:;" class="btn default"> Cancel </a>
                                        </div>
                                    </form>
                                </div>

                                <!-- END PERSONAL INFO TAB -->
                                <!-- CHANGE AVATAR TAB -->
                                                        
                                <!-- END PROFILE CONTENT -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}              <!-- END PAGE CONTENT INNER -->
@endsection
