@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Reservoir create</div>
                <div class="card-body">
                    <form method="POST" action="{{route('reservoir.store')}}">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="{{old('title')}}">
                            <small class="form-text text-muted">Reservoir title.</small>
                        </div>
                        <div class="form-group">
                            <label>Area</label>
                            <input type="text" name="area" class="form-control" value="{{old('area')}}">
                            <small class="form-text text-muted">Reservoir area.</small>
                        </div>
                        <div class="form-group">
                            <label>About</label>
                            <textarea type="text" name="about" class="form-control" id="summernote"> {{old('about')}} </textarea>
                            <small class="form-text text-muted">Reservoir about.</small>
                        </diV>
                        @csrf
                        <button class="btn btn-primary" type="submit">ADD</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>
@endsection