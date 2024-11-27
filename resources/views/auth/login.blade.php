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




<form action="/auth/signin" method="POST">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="inputEmail1" aria-describedby="emailHelp" name="email">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="passsword" class="form-label">Password</label>
        <input type="password" class="form-control" id="inputPassword1" name="password">
    </div>
    <div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
            <label class="form-check-label" for="rememberMe">Remember me</label>
        </div>
        <a href="/auth/forgot-password">Forgot password?</a>
    </div>
    <button type="submit" class="btn btn-primary mt-3">SignIn</button>
    </div>
    
</form>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>

    var toastElements = document.querySelectorAll('.toast');
    var toastList = [...toastElements].map(toastElement => new bootstrap.Toast(toastElement));
    toastList.forEach(toast => toast.show());
</script>
@endsection