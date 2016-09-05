
@extends('master')
@section('title', 'Manage Dashboard | CognitivoERP')
@section('Title', 'Manage Dashboard')
@section('innercontent')
  <div>
    <div >
      <ul id="UserComponents">
      @if( ! empty($Errors))
        @foreach($Errors as $error)
            <li>{{ $error }}</li>
        @endforeach
      @endif
      @if( ! empty($DashboardComponents))
        @foreach($DashboardComponents as $Component)
            <li>{{ $Component }}</li>
        @endforeach
      @endif
    </ul>
    <div id="ShowComponents"></div>
    </div>
    <a id="ListComponents">Add Components</a>
    <button id="UpdateUserDashboard">Done</button>
  </div>
@endsection
@section('pagescripts')
  <script src="{{url()}}/assets/pages/scripts/dashboard_app.js" type="text/javascript"></script>
@endsection
