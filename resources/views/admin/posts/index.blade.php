@extends('layouts.admin')

@section('content')
<div class="container my-4">

  <section class="d-flex justify-content-between align-items-center">
    <h1 class="d-inline">Lista dei Post</h1>
    <a class="btn btn-success" href="{{ route('admin.posts.create') }}">CREA</a>
  </section>

  @if(session('post_deleted'))
      <div class=" my-2 alert alert-success" role="alert">
        {{ session('post_deleted') }}
      </div>
  @endif
  
  <table class="table my-5">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Titolo</th>
        <th scope="col">Categoria</th>
        <th scope="col">Modifiche</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($posts as $post )

      <tr>
        <td>{{ $post->id }}</td>
        <td>{{ $post->title }}</td>
        <td>{{ $post->category ? $post->category->name : '-' }}</td>
        <td>
          <a class="btn btn-primary" href=" {{ route('admin.posts.show', $post)  }}">MOSTRA</a>
          <a class="btn btn-secondary" href="{{ route('admin.posts.edit', $post)  }}">MODIFICA</a>

          <form class= "d-inline"
                onsubmit= "return confirm('Vuoi eliminare definitivamente il post ## {{ $post->title }} ## ?')"
                action= "{{ route('admin.posts.destroy', $post) }}" method= "POST">
            @csrf
            @method ('DELETE')
            <button class="btn btn-danger">ELIMINA</button>
          </form>

        </td>
      </tr>
        
      @endforeach
      
    </tbody>
  </table>

  {{ $posts->links() }}

  <div class="categories my-5">
    
    <section class="d-flex justify-content-between align-items-center">
      <h2>Categorie</h2>
      <a class="btn btn-success" href="{{ route('admin.categories.create') }}">CREA CATEGORIA</a>
    </section>

    <div class="my-3" id="accordion">

      @foreach ($categories as $category )

        <div class="card my-2">
        
          <div class="card-header d-flex justify-content-between" id="headingOne">
            <h5 class="d-inline mb-0">
              <button class="btn btn-link" data-toggle="collapse" data-target="#category-{{$category->id}}" aria-expanded="true">
                {{$category->name}}
              </button>
            </h5>
            <a class="btn btn-secondary" href="{{ route('admin.categories.edit', $category) }}">MODIFICA NOME</a>
          </div>

          <div id="category-{{$category->id}}" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
            
              <ul>
                @foreach ($category->posts as $post )
                <li><a href="{{ route('admin.posts.show', $post) }}">ID: {{$post->id}} | {{$post->title}} </a></li>
                @endforeach
              </ul>
              
            </div>
          </div>
        </div>

      @endforeach

    </div>
  </div>

</div>
@endsection
