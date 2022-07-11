@extends('layouts.admin')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-8 offset-2">

                <section class = "d-flex justify-content-between align-items-center">
                    <h2 class="mb-3 d-inline">Modifica Categoria</h2>
                    <a class="btn btn-primary" href="{{ route('admin.posts.index') }}">INDIETRO</a>
                </section>

                <form action="{{ route('admin.categories.update',$category)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error )
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <label for="name" class="form-label">Nome Categoria</label>

                        <input type="text" 
                                id="name" 
                                name="name" 
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="Nome Categoria"
                                value="{{old('name',$category->name)}}">

                        @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror

                    </div>

                    <button type="submit" class="btn btn-success">SALVA</button>
                </form>
            </div>
        </div>

    </div>
@endsection