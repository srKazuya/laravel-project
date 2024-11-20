@extends('layout')
@section('content')
<div class="card text-center mt-4">
    <div class="card-header">
     Author: {{$user->name}}
    </div>
    <div class="card-body">
    <h5 class="card-title">{{$article->name}}</h5>
    <p class="card-text">{{$article->desc}}.</p>
    <div class="d-flex justify-content-end gap-3">
        <a href="/article/{{$article->id}}/edit" class="btn btn-primary">Edit article</a>
        <form action="/article/{{$article->id}}" method="POST">
            @method("DELETE")
            @csrf
            <button type="submit" class="btn btn-danger">Delete article</button>
        </form>
    </div>
    
    </div>
    <div class="card-footer text-body-secondary">
      {{$article->date}}</p>
    </div>
  </div>

@endsection