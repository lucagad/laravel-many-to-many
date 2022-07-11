@extends('layouts.admin')

@section('content')
  <div class="container my-4">
    <div class="row">
      <div class="col-8 offset-2">

        <section class = "d-flex justify-content-between align-items-center">
          <h2 class="mb-3 d-inline">Dettaglio del Post</h2>
          <a class="btn btn-primary" href="{{route('admin.posts.index')}}">INDIETRO</a>
        </section>

        <div class="row my-4 border border-dark rounded p-2">

          <div class="col-4 col-lg-2 d-flex justify-content-start align-items-center">
            {{-- Colonna Immagine --}}
          </div>

          <div class="col-8 col-lg-10 d-flex flex-column justify-content-center align-items-start">
              <h5>Titolo: {{ $post->title }}</h5>
              <h5>Categoria: {{ $post->category ? $post->category->name : ' - ' }}</h5>
              <p class="my-2 p-1 rounded">{{ $post->content }}</p>
          </div>

        </div>

        <a class="btn btn-secondary" href="{{ route('admin.posts.edit', $post)  }}">MODIFICA</a>

          <form class = "d-inline"
                onsubmit = "return confirm('Vuoi eliminare definitivamente il post ## {{ $post->title }} ## ?')"
                action = "{{ route('admin.posts.destroy', $post) }}" method="POST">
            @csrf
            @method ('DELETE')
            <button class="btn btn-danger">ELIMINA</button>
          </form>

      </div>
    </div>

  </div>

@endsection