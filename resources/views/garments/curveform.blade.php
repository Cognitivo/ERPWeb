@extends('master')
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
                @if(isset($data))
                {!! Form::model($data,['route' => ['curve.update',$data['name']], 'method'=>'put','class'=>'form-horizontal']) !!}
                @else
                {!! Form::open(array('route'=> 'curve.store','class'=>'form-horizontal')) !!}
                @endif
                {!! csrf_field() !!}

                <div class="form-group  margin-top-20">
                  <label class="control-label col-md-2">Nombre
                    <span class="required"> * </span>
                  </label>
                  <div class="col-md-4">
                    <div class="input-icon right">
                      <i class="fa"></i>
                      {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Name']) !!}
                    </div>
                  </div>
                </div>
                @for($i=0;$i<=$count;$i++)

                <div class="form-group">
                  <label class="control-label col-md-2">Size
                    <span class="required"> * </span>
                  </label>
                  <div class="col-md-4">
                  {!! Form::text('size[]', null, ['class'=>'form-control', 'placeholder'=>'size']) !!}
                  </div>
                </div>
            @endfor
                <div class="margiv-top-10">
                  {!! Form::submit( 'GUARDAR CAMBIOS', ['class'=>'btn green']) !!}
                  <a href="{{route('curve.index')}}" class="btn default"> CANCELAR</a>
                </div>
                {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </div>


              <!-- END PAGE CONTENT INNER -->
@endsection
