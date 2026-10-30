@extends('layouts.app')

@section('title', 'Add Category')
@section('subtitle', 'Create a new product category.')

@section('content')
    <section class="panel form-panel">
        <form action="{{ route('kategori.store') }}" method="POST">
            @include('kategori._form')
        </form>
    </section>
@endsection
