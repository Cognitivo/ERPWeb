
@extends('master')
@section('title', 'Manage Dashboard | CognitivoERP')
@section('Title', 'Manage Dashboard')
@section('innercontent')
    <div >
        <ul id="UserComponents">
            @if( ! empty($Errors))
                @foreach($Errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            @endif
        </ul>
    </div>
    <?php $cnt=0; ?>
    <div class="portlet-body form">
        {!! Form::open(array('url'=> 'savedashboard','class'=>'form-horizontal')) !!}
        {!! csrf_field() !!}
        <div class="form-group form-md-checkboxes">
            <label>Check/Uncheck Components</label>
            <div class="md-checkbox-list">
                <div class="row">
                    <?php if($cnt%10==0)?>
                    <div class="col-md-4">
                        @if( ! empty($Components))
                            @foreach($Components["All"] as $ComponentKey=>$ComponentName)
                                <?php $cnt++; ?>
                                @if(!empty($Components["User"][$ComponentKey]))
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="{{$ComponentKey}}" name="components[]" class="md-check" checked="" value="{{$ComponentKey}}">
                                        <label for="{{$ComponentKey}}">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> {{$ComponentName}} </label>
                                        </div>
                                    @else
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="{{$ComponentKey}}" name="components[]" class="md-check" value="{{$ComponentKey}}">
                                            <label for="{{$ComponentKey}}">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> {{$ComponentName}} </label>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                <?php if($cnt%10==0)?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="margiv-top-10">
                    {!! Form::submit( 'Save Changes', ['class'=>'btn green']) !!}
                    <a href="javascript:;" class="btn default"> Cancel </a>
                </div>
                {!! Form::close() !!}
            </div>
        @endsection
        @section('pagescripts')
            <script src="{{url()}}/assets/pages/scripts/dashboard_app.js" type="text/javascript"></script>
        @endsection
