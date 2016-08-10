

@extends('../../master')
@section('title', 'Contacts | CognitivoERP')
@section('Title', 'Contacts')

@section('content')
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption font-dark">


            </div>
            <div class="tools"></div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover order-column"   id="sample_1">

                <thead>
                <tr >
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Número</th>
                </tr>
              </thead>
                <tbody>
@foreach($contacts as $item)
<tr>

  <td>
    {{$item->timestamp}}
  </td>

<td>
  <a href="{{route('contacts.edit',$item->id_contact)}}">{{$item->name}}</a>

</td>
<td>
  {{$item->gov_code}}
</td>
</tr>
@endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
