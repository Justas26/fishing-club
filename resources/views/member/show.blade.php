@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Member information</div>
                <div class="card-body">
                    <table class="table-responsive-xl" >
                        <tr>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Live</th>
                            <th>Experience</th>
                            <th>Registered</th>
                            <th>Edit</th>
                            <th>Delete</th>         
                        </tr>
                        @foreach ($member as $member)
                        <tr>
                            <td>{{$member->name}}</td>
                            <td>{{$member->surname}}</td>
                            <td>{{$member->live}}</td>
                            <td>{{$member->expierence}}</td>
                            <td>{{$member->registered}}</td>
                             <td>   
                            <form action="{{route('member.uploadPhoto',$member)}}" method="post" enctype="multipart/form-data">
                            <input type="file" name="photo" id="">
                             @csrf
                            <button class="btn btn-success" type="submit">upload photo</button>
                            </form>
                            <a class="btn btn-primary" href="{{route('member.edit',$member)}}">edit</a></td>
                            <td>
                                <form method="POST" action="{{route('member.destroy', $member)}}">
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