@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Reservoir list</div>
                 <div class="mb-3">{{$reservoirs->links()}}</div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Title</th>
                            <th>Area</th>
                            <th>About</th>
                            <th>Photo</th>
                            <th>Show</th>
                        </tr>
                        @foreach ($reservoirs as $reservoir)
                        <tr>
                            <td>{{$reservoir->title}}</td>
                            <td>{{$reservoir->area}}</td>
                            <td>{!!$reservoir->about!!}</td>
                             <td>
                            <img src="{{asset('reservoirPhoto/'.$reservoir->photo_name)}}"alt="">
                            </td>
                            <td>
                            <a class="btn btn-primary" href="{{route('reservoir.show',$reservoir)}}">show</a>
                            </td>
                            <br>
                        </tr>
                        @endforeach
                    </table>
                </div>
                  <div class="mt-3">{{$reservoirs->links()}}</div>
            </div>
        </div>
    </div>
</div>
@endsection