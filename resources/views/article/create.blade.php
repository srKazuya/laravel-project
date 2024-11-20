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




<form action="/article" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name
        <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">date
            <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}">
    </div>
    <div class="mb-3">
        <label for="desc" class="form-label">Description</label>
        <input type="desc" class="form-control" id="desc" name="desc">
    </div>
    <button type="submit" class="btn btn-primary">Save aricle</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>

    var toastElements = document.querySelectorAll('.toast');
    var toastList = [...toastElements].map(toastElement => new bootstrap.Toast(toastElement));
    toastList.forEach(toast => toast.show());
</script>
@endsection