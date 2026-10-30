@extends('layouts.app')

@section('title', 'Add Product')
@section('subtitle', 'Create a new inventory product.')

@section('content')
    <section class="panel form-panel">
        <form action="{{ route('barang.store') }}" method="POST">
            @include('barang._form')
        </form>
    </section>
@endsection
