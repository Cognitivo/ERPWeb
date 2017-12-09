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

              {!! Form::open(array('route'=> 'garmentsproduction.fetch','class'=>'form-horizontal')) !!}

              <div class="portlet-body">
                <div class="form-group">
                  <label class="col-md-3 control-label">
                    Curve
                  </label>
                  <div class="col-md-9">
                      <select required class="js-example-basic-single" value="" name="id_curve">
                        <option value="">Select Curve</option>
                        @foreach ($Json as $element=>$value)

                              <option value="{{$value['name']}}">
                                {{ $value['name'] }}</option>

                            @endforeach
                          </select>

                  </div>
                      <div class="col-md-9">
                      {!! Form::submit( 'Fetch Data ', ['class'=>'btn green']) !!}
</div>
  {!! Form::close() !!}
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
                <div class="form-group">
                  <label class="col-md-3 control-label">
                    Line
                  </label>
                  <div class="col-md-9">
                      <select required class="js-example-basic-single" value="" name="id_production_line">
                        <option value="">Select Line</option>
                          @foreach ($lines as $line)

                              <option value="{{ $line->id_production_line }}">
                                {{ $line->name }}</option>

                            @endforeach
                          </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">Rango de Fecha</label>
                  <div class="col-md-9">
                    <div class="input-group defaultrange" >
                      {!! Form::text('range_date',null,['class'=>'form-control','readonly','required']) !!}
                      <span class="input-group-btn">
                        <button class="btn default date-range-toggle" type="button">
                        <i class="fa fa-calendar"></i>
                        </button>
                      </span>
                    </div>
                  </div>
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
                              		@foreach ($filterJson as $element=>$value)
                                   @if ($value!=" ")
                              		<tr>

                                    <td>  {{ $value }}</a></td>
                                    <td><input type="hidden" name="name[]"  value="{{ $value }}"></td>
                                    <td><input type="text" name="quantity[]"  value=""></td>




                              		</tr>
                                  @endif
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
