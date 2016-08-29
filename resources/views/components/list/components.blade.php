

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
          <div class="form-group">
              <a href="{{url('componentcreate')}}" class="btn btn-primary" id="create_contact">Create Component</a>
          </div>
            <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Module ID</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                
                  @foreach($Components as $Item)
                     <tr>
                   
                            <td>
                                {{$Item['Caption']}}
                            </td>
                            <td>
                                <a href="">{{$Item['Type']}}</a>
                            </td>
                            <td>
                                {{$Item['Module']}}
                            </td>
                            <td>
                                {{$Item['Description']}}
                            </td>
                        </tr> 
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
