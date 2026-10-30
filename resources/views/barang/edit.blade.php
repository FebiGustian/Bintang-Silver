@extends('layouts.app')

@section('title', 'Edit Product')
@section('subtitle', 'Update product information.')

@section('content')
    <section class="panel form-panel">
        <form action="{{ route('barang.update', $barang) }}" method="POST">
            @method('PUT')
            @include('barang._form')
        </form>
    </section>
@endsection
