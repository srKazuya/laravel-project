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

    @if (session('success'))
        <div aria-live="polite" aria-atomic="true">
            <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
                <div class="toast align-items-center text-bg-success border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div aria-live="polite" aria-atomic="true">
            <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
                <div class="toast align-items-center text-bg-danger border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="card text-center mt-4">
        <div class="card-header fw-bold">
            {{ $article->name }}
        </div>
        <div class="card-body">
            <p class="card-text text-start">{{ $article->desc }}</p>
            @can('update')
            <div class="d-flex justify-content-end gap-3 mt-4">
                <a href="/article/{{ $article->id }}/edit" class="btn btn-primary">Edit article</a>
                <form action="/article/{{ $article->id }}" method="POST">
                    @method("DELETE")
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete article</button>
                </form>
            </div>
            @endcan
        </div>
        <div class="card-footer text-body-secondary d-flex justify-content-between">
            <span class="text-xxl-start"> Author: {{ $user->name }}</span>
            <span class="text-xxl-end">{{ $article->created_at->format('d.m.Y H:i') }}</span>
        </div>
    </div>

    <div class="container mt-5">
        <h4>Комментарии</h4>
        @if ($comments->isEmpty())
            <p class="text-muted">Комментариев пока нет. Будьте первым!</p>
        @else
            <div class="list-group mt-4">
                @foreach ($comments as $comment)
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1 fw-bold">{{ $comment->name }}</h5>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ $comment->desc }}</p>
                        <div class="d-flex justify-content-end mt-2">
                        
                            @can('update_comment', $comment) 
                                <a href="/comment/{{ $comment->id }}/edit" class="btn btn-secondary btn-sm">Редактировать</a>
                                <a href="/comment/{{ $comment->id }}/delete" class="btn btn-danger btn-sm ms-2" 
                                   onclick="return confirm('Вы уверены, что хотите удалить этот комментарий?');">
                                    <i class="bi bi-trash"></i> Удалить
                                </a>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-5">
        <h4>Добавить комментарий</h4>

        <form action="/comment" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Название коментария</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Ваш комментарий</label>
                <textarea class="form-control" id="desc" name="desc" rows="4" required></textarea>
            </div>
            <input type="hidden" name="article_id" value="{{$article->id}}">
            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            var toastElements = document.querySelectorAll('.toast');
            var toastList = [...toastElements].map(toastElement => new bootstrap.Toast(toastElement));
            toastList.forEach(toast => toast.show());
        });
    </script>
@endsection
