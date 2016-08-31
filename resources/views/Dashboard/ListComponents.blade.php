<div id="components">
          @if( ! empty($Components))
            @foreach($Components as $Name=>$Key)
              <input type="checkbox" name="component" value="{{$Key}}" /><label>{{ $Name }} </label><br />
            @endforeach
          @endif
        <button id="AddComponents">Done</button>

</div>
