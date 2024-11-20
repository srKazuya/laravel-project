@extends('layout')

@section('content')

@if ($errors->any())
    <div aria-live="polite" aria-atomic="true">
        <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
            @foreach ($errors->all() as $error)
                <div class="toast align-items-center text-bg-danger border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ $error }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<form action="/article/{{ $article->id }}" method="POST" class="mt-4" >
  @csrf
  @method('PUT') 
  <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $article->name) }}">
  </div>

  <!-- Поле для даты -->
  <div class="mb-3">
      <label for="date" class="form-label">Date</label>
      <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $article->date) }}">
  </div>

  <!-- Поле для описания -->
  <div class="mb-3">
      <label for="desc" class="form-label">Description</label>
      <textarea class="form-control" id="desc" name="desc">{{ old('desc', $article->desc) }}</textarea>
  </div>

  <button type="submit" class="btn btn-primary">Save article</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>
    // Отображение всплывающих уведомлений (toast) при ошибках
    var toastElements = document.querySelectorAll('.toast');
    var toastList = [...toastElements].map(toastElement => new bootstrap.Toast(toastElement));
    toastList.forEach(toast => toast.show());
</script>

@endsection
