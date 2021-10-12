@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Member list</div>
                <form class="card-header" action="{{route('member.index')}}" method="get">
                    <fieldset>
                        <legend>Filter</legend>
                        <div class="block">
                            <div class="form-group">
                                <select name="reservoir_id">
                                    @foreach ($reservoirs as $reservoir)
                                    <option value="{{$reservoir->id}}">{{$reservoir->title}}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Select resevoir from the list.</small>
                            </div>
                        </div>
                        <div class="block">
                            <button type="submit" class="btn btn-info" name="filter" value="reservoir">Filter</button>
                            <a href="{{route('member.index')}}" class="btn btn-warning">Reset</a>
                        </div>
                    </fieldset>
                </form>
                <div class="card-body">
                     <div class="mb-3">{{$members->links()}}</div>
                    <table class="table" >
                        <tr>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Live</th>
                            <th>Experience</th>
                            <th>Registered</th>
                            <th>Photo</th>
                            <th>Show</th>         
                        </tr>
                        @foreach ($members as $member)
                        <tr>
                            <td>{{$member->name}}</td>
                            <td>{{$member->surname}}</td>
                            <td>{{$member->live}}</td>
                            <td>{{$member->expierence}}</td>
                            <td>{{$member->registered}}</td>
                            <td>
                            <img src="{{asset('memberPhoto/'.$member->photo_name)}}"alt="">
                            </td>
                            <td>
                            <a class="btn btn-primary" href="{{route('member.show',$member)}}">show</a>
                            </td>
                            <br>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="mt-3">{{$members->links()}}</div>
            </div>
        </div>
    </div>
</div>
@endsection