@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Member edit</div>
                <div class="card-body">
                    <form method="POST" action="{{route('member.update',$member)}}">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{old('name',$member->name)}}">
                            <small class="form-text text-muted">Member name.</small>
                        </div>
                        <div class="form-group">
                            <label>Surname</label>
                            <input type="text" name="surname" class="form-control" value="{{old('surname',$member->surname)}}">
                            <small class="form-text text-muted">Member surname.</small>
                        </div>
                        <div class="form-group">
                            <label>Live</label>
                            <input type="text" name="live" class="form-control" value="{{old('live',$member->live)}}">
                            <small class="form-text text-muted">Member live.</small>
                        </div>
                        <div class="form-group">
                            <label>Expierence</label>
                            <input type="text" name="expierence" class="form-control" value="{{old('expierence',$member->expierence)}}">
                            <small class="form-text text-muted">Member expierence.</small>
                        </div>
                        <div class="form-group">
                            <label>Registered</label>
                            <input type="text" name="registered" class="form-control" value="{{old('registered',$member->registered)}}">
                            <small class="form-text text-muted">Member registered.</small>
                        </div>
                        <select name="reservoir_id">
                            @foreach ($reservoirs as $reservoir)
                            <option value="{{$reservoir->id}}">{{$reservoir->title}}</option>
                            @endforeach
                        </select>
                        @csrf
                        <button class="btn btn-primary" type="submit">ADD</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection