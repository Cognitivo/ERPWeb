@extends('../../master')
@section('title', 'work | CognitivoERP')
@section('Title', 'Work Form')
@section('content')

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
                @if(isset($line))
                {!! Form::model($line,['route' => ['production_line.update',$line->id_production_line], 'method'=>'put','class'=>'form-horizontal']) !!}
                @else
                {!! Form::open(array('route'=> 'production_line.store','class'=>'form-horizontal')) !!}
                @endif
                {!! csrf_field() !!}
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
                {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </div>

  
              <!-- END PAGE CONTENT INNER -->
              @endsection