@extends("layout")

@section("content")

    <form action="{{$baseurl}}/postform" method="POST">
        <input type="text" value="" name="code">
        <input type="submit" name="Send">
    </form>

    @if (count($results)>0)
        @foreach ($results as $key => $value)
            <p> {{$key }} : {{ $value}}</p>
        @endforeach
    @else
        Enter a search term!
    @endif    
    
@endsection



