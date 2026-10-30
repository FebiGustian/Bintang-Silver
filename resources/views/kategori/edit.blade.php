@extends('layouts.app')

@section('title', 'Edit Category')
@section('subtitle', 'Update category information.')

@section('content')
    <section class="panel form-panel">
        <form action="{{ route('kategori.update', $kategori) }}" method="POST">
            @method('PUT')
            @include('kategori._form')
        </form>
    </section>
@endsection
