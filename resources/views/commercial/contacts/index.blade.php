

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
              <a href="{{ route('contacts.create') }}" class="btn btn-primary" id="create_contact">Create Contact</a>
  {!! Form::open(['method'=> 'GET']) !!}

                {!!Form::input('search','q',null,['placeholder'=>'Enter Text...'])!!}
            {!!Form::close()!!}
          </div>
            <table class="table table-hover table-light" id="sample_1">
                <thead>
                    <tr>
                        <th>Date</th>
                          <th>Code</th>
                        <th>Name</th>
                        <th>Government ID</th>
                        <th>Address</th>
                        <th>Telephone</th>
                    </tr>
                </thead>
                <tbody>

                  @foreach($contacts as $item)
                    @if ($item->is_active === 1)
                        <tr>
                    @else
                        <tr style="background-color:pink;">
                    @endif
                            <td>
                                {{ date('F d, Y', strtotime($item->timestamp)) }}
                            </td>
                            <td>
                                {{$item->code}}
                            </td>
                            <td>
                                <a href="{{route('contacts.edit',$item->id_contact)}}">{{$item->name}}</a>
                            </td>

                            <td>
                                {{$item->gov_code}}
                            </td>
                            <td>
                                {{$item->address}}
                            </td>
                            <td>
                                {{$item->telephone}}
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
                  {!! $contacts->render() !!}
        </div>
    </div>
@endsection
