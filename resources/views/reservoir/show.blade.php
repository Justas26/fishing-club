@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Reservoir information</div>
                <div class="card-body">
                    <table class="table-responsive-xl" >
                        <tr>
                            <th>Title</th>
                            <th>Area</th>
                            <th>About</th>
                            <th>Photo</th>
                            <th>Edit</th>
                            <th>Delete</th>         
                        </tr>
                        @foreach ($reservoir as $reservoir)
                        <tr>
                            <td>{{$reservoir->title}}</td>
                            <td>{{$reservoir->area}}</td>
                            <td>{!!$reservoir->about!!}</td>
                             <td>   
                            <form action="{{route('reservoir.uploadPhoto',$reservoir)}}" method="post" enctype="multipart/form-data">
                            <input type="file" name="photo" id="">
                             @csrf
                            <button class="btn btn-success" type="submit">upload photo</button>
                            </form>
                             </td>
                            <td> <a class="btn btn-primary" href="{{route('reservoir.edit',$reservoir)}}">edit</a></td>
                            <td>
                                <form method="POST" action="{{route('reservoir.destroy', $reservoir)}}">
                                    @csrf
                                    <button class="btn btn-danger" type="submit">DELETE</button>
                                </form>
                            </td>
                            <br>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection