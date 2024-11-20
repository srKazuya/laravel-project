
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
      <th scope="col">Date</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">Author</th>

    </tr>
  </thead>
  <tbody class="mt-4">
    @foreach($articles as $article)
    <tr>
      <th scope="row">{{$article->date}}</th>
      <td><a class='text-primary' href="/article/{{$article->id}}">{{$article->name}}</a></td>
      <td>{{$article->desc}}</td>
      <td>{{ User::find($article->user_id)->name }}</td>     
    </tr>
    @endforeach
  </tbody>
</table>
{{$articles->links() }}
@endsection