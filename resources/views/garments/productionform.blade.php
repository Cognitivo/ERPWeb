@extends('master')
@section('title', 'Prodcution | CognitivoERP')
@section('Title', 'Prodcution')
@section('content')

      <div class="profile-content">
        <div class="row">
          <div class="col-md-12">
            <div class="portlet light ">
              <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                  <i class="icon-globe theme-font hide"></i>
                  <span class="caption-subject font-blue-madison bold uppercase">Prodcution</span>
                </div>
              </div>
              <div class="portlet-body">
                @if(isset($id))
                {!! Form::model($id,['route' => ['garmentsproduction.update',$id], 'method'=>'put','class'=>'form-horizontal']) !!}
                @else
                {!! Form::open(array('route'=> 'garmentsproduction.store','class'=>'form-horizontal')) !!}
                @endif
                {!! csrf_field() !!}
                <div class="form-group">
                  <label class="col-md-3 control-label">
                    Item
                  </label>
                  <div class="col-md-9">
                      <select required class="js-example-basic-single" value="" name="id_item">
                        <option value="">Select Item</option>
                          @foreach ($item as $items)

                              <option value="{{ $items->id_item }}">
                                {{ $items->name }}</option>

                            @endforeach
                          </select>
                  </div>
                </div>
                <table class="table table-hover">
                	<thead>
                		<tr>
                			<th>Nombre</th>
                			<th>Value</th>
                		</tr>
                	</thead>
                	<tbody>
                		@foreach ($Json as $element=>$value)
                		<tr>
                			<td>{{ $value['size'] }}</td>
                            <td><input type="hidden" name="name[]"  value="{{ $value['name'] }}"></td>
                            <td><input type="text" name="quantity[]"  value=""></td>


                		</tr>
                		@endforeach
                	</tbody>
                </table>
                <div class="margiv-top-10">
                  {!! Form::submit( 'GUARDAR ', ['class'=>'btn green']) !!}
                  <a href="{{route('garmentsproduction.index')}}" class="btn default"> CANCELAR</a>
                </div>
                {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </div>


              <!-- END PAGE CONTENT INNER -->
@endsection
