@extends('layouts.admin')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-8 offset-2">

                <section class = "d-flex justify-content-between align-items-center">
                    <h2 class="mb-3 d-inline">Aggiungi nuovo Post</h2>
                    <a class="btn btn-primary" href="{{ route('admin.posts.index') }}">INDIETRO</a>
                </section>

                <form action="{{ route('admin.posts.store')}}" method="POST">
                    @csrf
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

                        <label for="title" class="form-label">Titolo del Post</label>

                        <input type="text" 
                                id="title" 
                                name="title" 
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="Titolo del Post"
                                value="{{old('title')}}">

                        @error('title')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror

                    </div>

                    <div class="mb-3">
                        
                        <label for="content" class="form-label">Contenuto del Post</label>

                        <textarea type="text"
                                id="content" 
                                name="content" 
                                class="form-control @error('content') is-invalid @enderror"
                                placeholder="Contenuto del Post">{{old('content')}}</textarea>

                        @error('type')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror

                    </div>

                    <div class="mb-3">
                        
                        <label for="category_id" class="form-label">Categoria del Post</label>

                        <select type="text"
                                id="category_id" 
                                name="category_id" 
                                class="form-control @error('content') is-invalid @enderror">
                            
                                <option value="NULL" selected>Seleziona la Categoria</option>

                                @foreach ($categories as $category )
                                    <option @if ($category->id == old ('category_id')) selected @endif value="{{$category->id}}" >{{$category->name}}</option>
                                @endforeach

                            </select>

                        @error('type')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror

                    </div>

                    {{-- <div class="mb-3">
                        <label for="image" class="form-label">URL Image</label>
                        <input type="text" 
                                id="image" 
                                name="image" 
                                class="form-control @error('image') is-invalid @enderror"
                                placeholder="URL Image"
                                value="{{old('image')}}" >
                        @error('image')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div> --}}

                    <button type="submit" class="btn btn-success">SALVA</button>
                </form>
            </div>
        </div>

    </div>
@endsection