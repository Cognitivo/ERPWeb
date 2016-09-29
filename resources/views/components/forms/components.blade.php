@extends('../../master')

@section('title', 'Components | CognitivoERP')
@section('Title', 'Components Form')

@section('content')
@if(isset($ComponentInfo))
{!! Form::open(array('url'=> 'updatecomponent','class'=>'form-horizontal','id'=>'componentform')) !!}

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
                                          <input type="text" placeholder="Name Of The Component" class="form-control" name="name" value="{{$ComponentInfo['Caption']}}"/>
                                      </div>
                                          <div class="form-group form-md-radios">
                                            <label>Type</label>
                                            <div class="md-radio-list">
                                                <div class="md-radio">
                                                    @if($ComponentInfo['Type'] == 'kpi')
                                                    <input type="radio" id="radio1" name="type" class="md-radiobtn" value="kpi" required checked="true">
                                                    @else
                                                    <input type="radio" id="radio1" name="type" class="md-radiobtn" value="kpi" required>
                                                    @endif
                                                    <label for="radio1">
                                                        <span class="inc"></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> KPI </label>
                                                    <div class="reveal-if-active">
                                    
                                                    </div>
                                                </div>
                                                <div class="md-radio">
                                                    @if($ComponentInfo['Type'] == 'BarChart')
                                                    <input type="radio" id="radio2" name="type" class="md-radiobtn" value="BarChart" checked="true">
                                                    @else
                                                    <input type="radio" id="radio2" name="type" class="md-radiobtn" value="BarChart">
                                                    @endif
                                                    <label for="radio2">
                                                        <span class="inc"></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Bar Chart </label>
                                                    @if($ComponentInfo['Type'] == 'BarChart')
                                                    <div class="reveal-if-active">
                                                        <label class="control-label">X-Axis</label>
                                                        <input type="text" placeholder="Name of column for X-Axis" class="form-control" name="xaxis" value="{{$ComponentInfo['Label']}}"/>
                                                        <label class="control-label">Y-Axis</label>
                                                        <input type="text" placeholder="Name of column for Y-Axis" class="form-control" name="yaxis" value="{{$ComponentInfo['Series'][0]['Id']}}"/>
                                                        <label class="control-label">Y-Axis Column</label>
                                                        <input type="text" placeholder="Column for Y-Axis" class="form-control" name="yaxiscolumn" value="{{$ComponentInfo['Series'][0]['Column']}}"/>
                                                        <label class="control-label">Y-Axis Caption</label>
                                                        <input type="text" placeholder="Caption for Y-Axis" class="form-control" name="yaxiscaption" value="{{$ComponentInfo['Series'][0]['Name']}}"/>
                                                        <label class="control-label">Y-Axis Color</label>
                                                        <input type="text" placeholder="Color for Y-Axis" class="form-control" name="yaxiscolor" value="{{$ComponentInfo['Series'][0]['Color']}}"/>
                                                    </div>
                                                    @else
                                                    <div class="reveal-if-active">
                                                        <label class="control-label">X-Axis</label>
                                                        {!! Form::text('xaxis', null, ['class'=>'form-control', 'placeholder'=>'Name of column for X-Axis']) !!}
                                                        <label class="control-label">Y-Axis</label>
                                                        {!! Form::text('yaxis', null, ['class'=>'form-control', 'placeholder'=>'Name of column for Y-Axis']) !!}
                                                        <label class="control-label">Y-Axis Column</label>
                                                        {!! Form::text('yaxiscolumn', null, ['class'=>'form-control', 'placeholder'=>'Column for Y-Axis']) !!}
                                                        <label class="control-label">Y-Axis Caption</label>
                                                        {!! Form::text('yaxiscaption', null, ['class'=>'form-control', 'placeholder'=>'Caption for Y-Axis']) !!}
                                                        <label class="control-label">Y-Axis Color</label>
                                                        {!! Form::text('yaxiscolor', null, ['class'=>'form-control', 'placeholder'=>'Color for Y-Axis']) !!}
                                                    </div>
                                                    @endif
                                                    
                                                </div>
                                                <div class="md-radio">
                                                    @if($ComponentInfo['Type'] == 'PieChart')
                                                    <input type="radio" id="radio3" name="type" class="md-radiobtn" value="PieChart" checked="true">
                                                    @else
                                                    <input type="radio" id="radio3" name="type" class="md-radiobtn" value="PieChart">
                                                    @endif
                                                    <label for="radio3">
                                                        <span class="inc"></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Pie Chart </label>
                                                    <div class="reveal-if-active">
                                                        @if($ComponentInfo['Type'] == 'PieChart')
                                                        <label class="control-label">Label</label>
                                                        <input type="text" placeholder="Label Column for the Pie Chart" class="form-control" name="label" value="{{$ComponentInfo['Label']}}"/>
                                                        <label class="control-label">Pie Values</label>
                                                        <input type="text" placeholder="Pie Value Column for the Pie Chart" class="form-control" name="label" value="{{$ComponentInfo['PieValues']}}"/>
                                                        @else
                                                        <label class="control-label">Label</label>
                                                        {!! Form::text('label', null, ['class'=>'form-control', 'placeholder'=>'Label COlumn for the Pie Chart']) !!}
                                                        <label class="control-label">Pie Values</label>
                                                        {!! Form::text('pievalues', null, ['class'=>'form-control', 'placeholder'=>'Pie Value Column for the Pie Chart']) !!}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Unit</label>
                                            @if(isset($ComponentInfo['Unit']))
                                            <input type="text" placeholder="Unit Of The Result" class="form-control" name="unit" value="{{$ComponentInfo['Unit']}}"/>
                                            @else
                                            {!! Form::text('unit', null, ['class'=>'form-control', 'placeholder'=>'Unit Of The Result']) !!}
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Module</label>
                                            @if(isset($ComponentInfo['Module']))
                                            <input type="text" placeholder="Access Module" class="form-control" name="module" value="{{$ComponentInfo['Module']}}"/>
                                            @else
                                            {!! Form::text('module', null, ['class'=>'form-control', 'placeholder'=>' Access Module']) !!}
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Description</label>
                                            @if(isset($ComponentInfo['Description']))
                                            <input type="text" class="form-control" name="description" value="{{$ComponentInfo['Description']}}"/>
                                            @else
                                            {!! Form::text('description', null, ['class'=>'form-control']) !!}
                                            @endif
                                        </div><div class="form-group">
                                            <label class="control-label">Query</label>
                                            <textarea rows="3" class="form-control" name="query" value="" placeholder="Query of the Component">
                                            {{$ComponentInfo['Query']}}
                                            </textarea>
                                        </div>
                                        <div class="margiv-top-10">
                                            <input type="hidden" name="key" value="{{$ComponentInfo['Key']}}">
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
</div>        <!-- END PAGE CONTENT INNER -->
@else
{!! Form::open(array('url'=> 'createcomponent','class'=>'form-horizontal','id'=>'componentform')) !!}

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
                                      <p>I am in Insert</p>
                                          <label class="control-label">Name</label>
                                          {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Name Of The Component','required'=>'']) !!}
                                      </div>
                                          <div class="form-group form-md-radios">
                                            <label>Type</label>
                                            <div class="md-radio-list">
                                                <div class="md-radio">
                                                    <input type="radio" id="radio1" name="type" class="md-radiobtn" value="kpi" required>
                                                    <label for="radio1">
                                                        <span class="inc"></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> KPI </label>
                                                    <div class="reveal-if-active">
                                    
                                                    </div>
                                                </div>
                                                <div class="md-radio">
                                                    <input type="radio" id="radio2" name="type" class="md-radiobtn" value="BarChart">
                                                    <label for="radio2">
                                                        <span class="inc"></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Bar Chart </label>
                                                    <div class="reveal-if-active">
                                                        <label class="control-label">X-Axis</label>
                                                        {!! Form::text('xaxis', null, ['class'=>'form-control', 'placeholder'=>'Name of column for X-Axis']) !!}
                                                        <label class="control-label">Y-Axis</label>
                                                        {!! Form::text('yaxis', null, ['class'=>'form-control', 'placeholder'=>'Name of column for Y-Axis']) !!}
                                                        <label class="control-label">Y-Axis Column</label>
                                                        {!! Form::text('yaxiscolumn', null, ['class'=>'form-control', 'placeholder'=>'Column for Y-Axis']) !!}
                                                        <label class="control-label">Y-Axis Caption</label>
                                                        {!! Form::text('yaxiscaption', null, ['class'=>'form-control', 'placeholder'=>'Caption for Y-Axis']) !!}
                                                        <label class="control-label">Y-Axis Color</label>
                                                        {!! Form::text('yaxiscolor', null, ['class'=>'form-control', 'placeholder'=>'Color for Y-Axis']) !!}
                                                    </div>
                                                    
                                                </div>
                                                <div class="md-radio">
                                                    <input type="radio" id="radio3" name="type" class="md-radiobtn" value="PieChart">
                                                    <label for="radio3">
                                                        <span class="inc"></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Pie Chart </label>
                                                    <div class="reveal-if-active">
                                                        <label class="control-label">Label</label>
                                                        {!! Form::text('label', null, ['class'=>'form-control', 'placeholder'=>'Label COlumn for the Pie Chart']) !!}
                                                        <label class="control-label">Pie Values</label>
                                                        {!! Form::text('pievalues', null, ['class'=>'form-control', 'placeholder'=>'Pie Value Column for the Pie Chart']) !!}
                                                    </div>
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
                                            {!! Form::textarea('query', null, ['class'=>'form-control', 'rows'=>'3', 'placeholder'=>'Query of the Component','required'=>'']) !!}
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
</div>        <!-- END PAGE CONTENT INNER -->
@endif
@endsection
@section('pagescripts')
<script src="{{url()}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="{{url()}}/assets/pages/scripts/componentform-validate.js" type="text/javascript"></script>
@endsection
