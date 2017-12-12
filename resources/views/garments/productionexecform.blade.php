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



                {!! Form::open(array('route'=> 'garmentsproductionexec.store','class'=>'form-horizontal')) !!}

                {!! csrf_field() !!}
                    </div>
                       <table class="table table-hover">
                              	<thead>
                              		<tr>
                              			<th>Nombre</th>
                                    <th>Order Value</th>
                              			<th>Value</th>
                              		</tr>
                              	</thead>
                              	<tbody>
                              		@foreach ($details as $detail)

                              		<tr>

                                    <td>  {{ $detail->name }}</a></td>
                                    <td>  {{ $detail->quantity }}</a></td>
                                    
                                    <td><input type="hidden" name="detail[]"  value="{{$detail->id_order_detail}}"></td>
                                    <td><input type="text" name="quantity[]"  value=""></td>




                              		</tr>

                              		@endforeach
                              	</tbody>
                              </table>


                <div class="margiv-top-10">
                  {!! Form::submit( 'GUARDAR ', ['class'=>'btn green']) !!}

                </div>
                {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </div>


              <!-- END PAGE CONTENT INNER -->
@endsection
