@extends('../../master')
@section('title', 'Contacts | CognitivoERP')
@section('Title', 'Contact Form')
@if(Session::has('message'))
<div class="alert alert-danger alert-dismissable" id="result">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <p id="message">
        {{Session::get('message')}}
    </p>
</div>
@endif
@section('content')

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                <!-- PORTLET MAIN -->
                <div class="portlet light profile-sidebar-portlet ">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                    <img src="../assets/pages/media/profile/profile_user.jpg" class="img-responsive" alt=""> </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">'contacts' </div>
                        <div class="profile-usertitle-job"> 'contacts' </div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS -->
                    <div class="profile-userbuttons">
                        <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                        <button type="button" class="btn btn-circle red btn-sm">Message</button>
                    </div>
                    <!-- END SIDEBAR BUTTONS -->
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <ul class="nav">
                            <li class="active">
                                <a href="#">
                                <i class="icon-user"></i> Overview </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END MENU -->
                </div>
                <!-- END PORTLET MAIN -->
                <!-- PORTLET MAIN -->
                <div class="portlet light ">
                    <!-- STAT -->
                    <div class="row list-separated profile-stat">
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="uppercase profile-stat-title"> 37 </div>
                            <div class="uppercase profile-stat-text"> Projects </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="uppercase profile-stat-title"> 51 </div>
                            <div class="uppercase profile-stat-text"> Tasks </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <div class="uppercase profile-stat-title"> 61 </div>
                            <div class="uppercase profile-stat-text"> Uploads </div>
                        </div>
                    </div>
                    <!-- END STAT -->
                    <div>
                        <!-- <h4 class="profile-desc-title">About Marcus Doe</h4>
                        <span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
                        <div class="margin-top-20 profile-desc-link">
                            <i class="fa fa-globe"></i>
                            <a href="http://www.keenthemes.com">www.keenthemes.com</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                            <i class="fa fa-twitter"></i>
                            <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
                        </div>
                        <div class="margin-top-20 profile-desc-link">
                            <i class="fa fa-facebook"></i>
                            <a href="http://www.facebook.com/keenthemes/">keenthemes</a>
                        </div> -->
                    </div>
                </div>
                <!-- END PORTLET MAIN -->
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Contact</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">Información</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab">Localización</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_3" data-toggle="tab">Relación</a>
                                    </li>
                                    {{--  <li>
                                        <a href="#tab_1_4" data-toggle="tab">Commercial</a>
                                    </li> --}}
                                    <li>
                                        <a href="#tab_1_5" data-toggle="tab">Subscripción</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_6" data-toggle="tab">Etiqueta</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_7" data-toggle="tab">Finanza</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane active" id="tab_1_1">
                                            @if(isset($contacts))
                                            {!! Form::model($contacts,['route' => ['contacts.update',$contacts->id_contact], 'method'=>'put']) !!}
                                            @else
                                            {!! Form::open(array('route'=> 'contacts.store','class'=>'form-horizontal')) !!}
                                            @endif
                                            {!! csrf_field() !!}

                                                @if (isset($contacts) && $contacts->parent_id_contact != null)
                                                        <h5>Contacto Principal</h5>
                                                     <h3><b>{{ $contacts->parentContact->name }}</b></h3>
                                                @endif

                                            <div class="form-group">
                                                <label class="control-label">CODIGO</label>
                                                @if (isset($contacts))
                                                {!! Form::text('code', null, ['class'=>'form-control', 'placeholder'=>'Code']) !!}
                                                @else
                                                {!! Form::text('code', \App\Contact::last_contact()[0]->code+1, ['class'=>'form-control', 'placeholder'=>'Code']) !!}
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">ROL</label>
                                                {!!  Form::select('id_contact_role',$contactrole,null,['class'=> 'form-control' ,'required']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">NOMBRE</label>
                                                {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Full Name']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">ALIAS</label>
                                                {!! Form::text('alias', null, ['class'=>'form-control', 'placeholder'=>'Short Name or Alias']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">RUC</label>
                                                {!! Form::text('gov_code', null, ['class'=>'form-control', 'placeholder'=>'80001234-x']) !!}
                                            </div>
                                            <div class="form-group">
                                                <div class="md-checkbox">
                                                    {!! Form::checkbox('is_person',null, null, ['class'=>'md-check', 'id'=>'chbxPerson']) !!}
                                                    <label for="chbxPerson">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>
                                                        Person
                                                        <label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">GENERO</label>
                                                        {!! Form::select('gender',['Male','Female'], null, ['class'=>'form-control']) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">FECHA DE NACIMIENTO</label>
                                                        {!! Form::date('date_birth', null, ['class'=>'form-control form-control-inline input-medium ']) !!}
                                                    </div>
                                                    <hr/>
                                                    <div class="form-group">
                                                        <label class="control-label">CORREO</label>
                                                        {!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'hola@hotmail.com']) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">TELEFONO</label>
                                                        {!! Form::text('telephone', null, ['class'=>'form-control', 'placeholder'=>'+595 21 3288271']) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">COMENTARIO</label>
                                                        {!! Form::text('comment', null, ['class'=>'form-control']) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Entry Date</label>
                                                        {!! Form::text('timestamp', null, ['class'=>'form-control','readonly'=>'true']) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">DIRECCION</label>
                                                        {!! Form::textarea('address', null, ['class'=>'form-control', 'rows'=>'3', 'placeholder'=>'Roque Centurion Miranda Nro.1625 n/ Asuncion, Paraguay']) !!}
                                                    </div>
                                                    <div class="margiv-top-10">
                                                        {!! Form::submit( 'GUARDAR CAMBIOS', ['class'=>'btn green']) !!}
                                                        <a href={{route('contacts.index')}} class="btn default"> CANCELAR</a>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="tab_1_2">
                                            </div>
                                            <!-- END PERSONAL INFO TAB -->
                                            <!-- CHANGE AVATAR TAB -->
                                            <div class="tab-pane" id="tab_1_3">

                                                    <div class="form-group">
                                                        <a href="{{ route('relation.create') }}" class="btn btn-primary" id="create_contact">CREAR RELACION</a>
                                                    </div>
                                                    <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
                                                        <thead>
                                                            <tr>
                                                                <th>CODIGO</th>
                                                                <th>NOMBRE</th>
                                                                <th>RUC</th>
                                                                <th>RELACION</th>
                                                                <td>ACCIONES</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($relation as $relations)
                                                            <td>
                                                                {{$relations->Code}}
                                                            </td>
                                                            <td>
                                                                {{$relations->name}}
                                                            </td>
                                                            <td>
                                                                {{$relations->gov_code}}
                                                            </td>
                                                            <td>
                                                                {{$relations->ContactRole->name}}
                                                            </td>
                                                            <td><a href="{{route('relation.edit', $relations)}}" style="display: inline;" >
                                                                <i class="glyphicon glyphicon-pencil"></i>
                                                            </a>/
                                                            <form action="{{route('relation.destroy', $relations)}}" method="POST" style="display: inline">
                                                                <input type="hidden" name="_method" value="delete">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <button type="submit" name="">
                                                                <i class="glyphicon glyphicon-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="tab_1_5">
                                        <div class="form-group">
                                            <a href="{{ route('subscription.create') }}" class="btn btn-primary" id="create_contact">CREAR SUSBSCRIPCION</a>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
                                            <thead>
                                                <tr>
                                                    <th>NOMBRE</th>
                                                    <th>PLAN</th>
                                                    <th>FECHA INICIO</th>
                                                    <th>FECHA FIN</th>
                                                    <th>PRECIO UNITARIO</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" name="" value="{{   $total=0 }}">
                                                @foreach($contact_subscription as $subscription)
                                                <td>{{ $subscription->Contacts->name }}</td>
                                                <td>
                                                    {{$subscription->Items->name}}
                                                </td>
                                                <td>
                                                    {{$subscription->start_date}}
                                                </td>
                                                <td>
                                                    {{$subscription->end_date}}
                                                </td>
                                                <td>
                                                    {{number_format($subscription->unit_price,0)}}
                                                </td>
                                                <td><a href="{{route('subscription.edit', $subscription)}}" style="display: inline;" >
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>/
                                                <form action="{{route('subscription.destroy', $subscription)}}" method="POST" style="display: inline">
                                                    <input type="hidden" name="_method" value="delete">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" name="">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <input type="hidden" name="" value="{!! $total += $subscription->unit_price !!}">
                                        @endforeach
                                    </tbody>
                                </table>
                                <div  align="right">
                                <h1 style="display: inline;">{{ number_format($total,0) }}</h1></div>
                            </div>
                            <div class="tab-pane" id="tab_1_6">
                                <form role=form action="#">
                                    @if (isset($contacts))
                                    <div class="form-group">
                                        <a href="{{ route('tag.create') }}" class="btn btn-primary" id="create_tag">AÑADIR ETIQUETA</a>
                                    </div>
                                    @endif
                                    <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th>ETIQUETA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($contact_tag as $tag)
                                            <td>
                                                {{$tag->Tag->name}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab_1_7">
                            @if (isset($contacts))
                            {!! Form::model($contacts,['route' => ['contacts.update',$contacts->id_contact], 'method'=>'put']) !!}
                            {!! csrf_field() !!}
                            <input type="hidden" name="is_finance" value="1">
                            <div class="form-group">
                                <div  class="md-checkbox-inline">
                                    <div class="md-checkbox">
                                        {!! Form::checkbox('is_customer',null, null, ['class'=>'md-check', 'id'=>'chbxCustomer']) !!}
                                        <label for="chbxCustomer">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            Cliente
                                            <label>
                                            </div>
                                            <div class="md-checkbox">
                                                {!! Form::checkbox('is_supplier',null, null, ['class'=>'md-check', 'id'=>'chbxSupplier']) !!}
                                                <label for="chbxSupplier">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                    Proveedor
                                                    <label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">CONTRATO</label>
                                                {!! Form::select('id_contract',$contract, null, ['class'=>'form-control']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">MONEDA</label>
                                                {!! Form::select('id_currency',$currency, null, ['class'=>'form-control']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">BANCO</label>
                                                {!! Form::select('id_bank',$bank, null, ['class'=>'form-control']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">LISTA DE PRECIO</label>
                                                {!! Form::select('id_price_list',$price_list, null, ['class'=>'form-control']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">VENDEDOR</label>
                                                {!! Form::select('id_sales_rep',$sales_rep, null, ['class'=>'form-control']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">CUENTA</label>
                                                {!! Form::select('id_field',$account,null, ['class'=>'form-control']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">NUMERO DE CUENTA</label>
                                                @if (App\ContactField::get_field_value($contacts->id_contact)->get()->count())
                                                {!! Form::text('account_value',App\ContactField::get_field_value($contacts->id_contact)->get()[0]->value, ['class'=>'form-control']) !!}
                                                @else
                                                {!! Form::text('account_value',null, ['class'=>'form-control']) !!}
                                                @endif
                                            </div>
                                            <div class="margiv-top-10">
                                                {!! Form::submit( 'Guardar', ['class'=>'btn green']) !!}
                                            </div>
                                            {!! Form::close() !!}
                                            @endif
                                        </div>
                                        <!-- END PROFILE CONTENT -->
                                    </div>
                                </div>
                            </div>
                            <!-- END PAGE CONTENT INNER -->
                            @endsection
