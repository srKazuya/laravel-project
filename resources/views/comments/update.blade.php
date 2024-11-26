@extends('layout')

@section('content')



<form action="/comment/{{ $comment->id}}/update" method="POST" class="mt-4" >
  @csrf
  @method('PUT')
  <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $comment->name) }}">
  </div>



  <!-- Поле для описания -->
  <div class="mb-3">
      <label for="desc" class="form-label">Description</label>
      <textarea class="form-control" id="desc" name="desc">{{ old('desc', $comment->desc) }}</textarea>
  </div>

  <button type="submit" class="btn btn-primary">Save article</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>
  // Отображение всплывающих уведомлений (toast) при ошибках и сессионных сообщениях
  document.addEventListener('DOMContentLoaded', () => {
      var toastElements = document.querySelectorAll('.toast');
      var toastList = [...toastElements].map(toastElement => new bootstrap.Toast(toastElement));
      toastList.forEach(toast => toast.show());
  });
</script>

@endsection
