
@extends('layout')
@section('content')
@use('App\Models\User', 'User')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<table class="table">
  <thead>
    <tr>
      <th scope="col">Article</th>
      <th scope="col">desc</th>
      <th scope="col">Date</th>
      <th scope="col">Author</th>

    </tr>
  </thead>
  <tbody class="mt-4">
    @foreach($comments as $comment)
    <tr>
      <th scope="row">{{$comment->article_id}}</th>
      <td>{{$comment->desc}}</td>
      <td>{{$comment->created_at->diffForHumans() }}</td>
      <td>{{ User::find($comment->user_id)->name }}</td>
      @if(!$comment->accept)
      <td><a class="btn btn-success" href="/comment/{{$comment->id}}/accept">Accept</a></td>
      @else
      <td><a class="btn btn-danger" href="/comment/{{$comment->id}}/reject">Reject</a></td>
      @endif
      {{-- <td>{{ User::find($article->user_id)->name }}</td>      --}}
    </tr>
    @endforeach
  </tbody>
</table>
{{-- {{$articles->links() }} --}}
@endsection