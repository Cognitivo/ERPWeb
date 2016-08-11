@extends('../../master')

@section('title', $contacts->name.'| CognitivoERP')
@section('Title', $contacts->name)

@section('content')
{!! Form::model($contacts,['route' => ['contacts.update',$contacts->id_contact], 'method'=>'put']) !!}

{!! csrf_field() !!}
<div>
      <div class="portlet-body">
          <ul class="nav nav-tabs">
              <li class="active">
                  <a href="#tab_1_1" data-toggle="tab">Information</a>
              </li>
              <li>
                  <a href="#tab_1_2" data-toggle="tab">Maps</a>
              </li>
              <li>
                  <a href="#tab_1_3" data-toggle="tab">Relationship</a>
              </li>
              <li>
                  <a href="#tab_1_4" data-toggle="tab">Commercial</a>
              </li>
              <li>
                  {!! Form::submit( 'Update', ['class'=>'btn btn-toolbar']) !!}
              </li>
          </ul>
          <div class="tab-content">
              <div class="tab-pane fade active in" id="tab_1_1">
                  <div class="form-body">
                    <div class="form-group form-md-line-input">
                    <label class="col-md-2 control-label" for="form_control_1">Regular input</label>
                    <div class="col-md-10">
                    <input type="text" class="form-control" id="form_control_1" placeholder="Enter your name">
                    <div class="form-control-focus"> </div>
                    </div>
                    </div>
                      <div class="form-group form-md-line-input form-md-floating-label has-info">
                          {!! Form::text('name', null, ['class'=>'form-control input-sm']) !!}
                          <label for="form_control_1">Name</label>
                      </div>
                      <div class="form-group form-md-line-input form-md-floating-label has-info">
                          {!! Form::text('alias', null, ['class'=>'form-control']) !!}
                          <label for="form_control_1">Alias</label>
                      </div>
                      <div class="form-group form-md-line-input form-md-floating-label has-info">
                          {!! Form::text('gov_code', null, ['class'=>'form-control']) !!}
                          <label for="form_control_1">Government ID</label>
                      </div>
                      <div class="form-group form-md-line-input">
                          {!! Form::textarea('address', null, ['class'=>'form-control']) !!}
                          <label for="form_control_1">Address</label>
                      </div>
                      <div class="form-group">
                          {{ Form::checkbox('is_active', 1, null, ['class' => 'md-check']) }}
                      </div>
                  </div>
                  </div>
          </div>

          <div class="tab-pane fade active in" id="tab_1_2">
              <div class="col-md-4">
                  <div class="form-group">

                  </div>
              </div>
          </div>

          <div class="tab-pane fade active in" id="tab_1_3"></div>
          <div class="tab-pane fade active in" id="tab_1_4"></div>
        </div>
      </div>
    </div>
{!!Form::close()!!}

@endsection
