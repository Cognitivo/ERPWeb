@extends('../../master')

@section('title', '{{$contacts->name}} | ERPWeb')
@section('Title', '{{$contacts->name}}')

@section('content')

<form class="form-horizontal">


<div class="col-md-8">
      <div class="portlet-body">
          <ul class="nav nav-tabs">
              <li class="active">
                  <a href="#tab_1_1" data-toggle="tab"> Information </a>
              </li>
              <li>
                  <a href="#tab_1_2" data-toggle="tab"> Geography </a>
              </li>
              <li>
                  <a href="#tab_1_3" data-toggle="tab"> Relation </a>
              </li>
              <li>
                  <a href="#tab_1_3" data-toggle="tab"> finance </a>
              </li>
          </ul>
          <div class="tab-content">
              <div class="tab-pane fade active in" id="tab_1_1">
                    <div class="col-md-4">
                      <div class="form-group">
                          <label class="col-md-3 control-label">Name</label>
                           <div class="col-md-9">
                              <input type="text" name="txtname" class="form-control" placeholder="Name" value="{{$contacts->name}}">
                            </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label class="col-md-3 control-label">Alias</label>
                           <div class="col-md-9">
                              <input type="text" name="txtalias" class="form-control" placeholder="Alias" value="{{$contacts->alias}}">
                            </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label class="col-md-3 control-label">GovenmentID</label>
                           <div class="col-md-9">
                              <input type="text" name="txtGovenmentID" class="form-control" placeholder="GovenmentID" value="{{$contacts->gov_code}}">
                            </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label class="col-md-3 control-label">Code</label>
                           <div class="col-md-9">
                              <input type="text" name="txtCode"  class="form-control" placeholder="Code" value="{{$contacts->code}}">
                            </div>
                      </div>
                    </div>
              </div>
                  <div class="col-md-4">
                  </div>
                  <div class="col-md-4">
                  </div>
              </div>
              <div class="tab-pane fade" id="tab_1_2">

              </div>
              <div class="tab-pane fade" id="tab_1_3">

              </div>
          </div>
    </div>

    <div class="col-md-4">


        <div class='form-group'>

            <label for="name" class="col-sm-3 control-label">Cliente:</label>
            <div class="col-sm-8">
                <input type="text" name="name" class="form-control" value="" />
                <div class="panel-heading clearfix">

                </div>
                <i class="icon-plus col-md-2"></i><i class="icon-pencil col-md-2" ></i><i class="icon-settings col-md-2" ></i>

            </div>
        </div>




    </div>

    <div class="col-md-4">
        <div class="form-group">
            <div class="col-sm-8">
                <button class="btn btn-default">Cargar Retención</button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-8">
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </div>

    </div>


</form>

@endsection
