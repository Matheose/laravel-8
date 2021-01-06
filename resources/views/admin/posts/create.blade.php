@extends('admin.layouts.app')

@section('title', 'Criar Novo Post')

@section('content')

    <h1>Cadastrar Novo Post</h1>

    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
        @include('admin.posts._partials.form')
    </form>

@endsection



    {{-- <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Título">
    <textarea name="content" id="content" cols="30" rows="4" placeholder="Conteúdo">{{ old('content')}}</textarea>
    <button type="submit">Enviar</button> --}}
