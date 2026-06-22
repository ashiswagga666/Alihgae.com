@extends('layouts.app')

@section('title', 'Temukan Karir Impianmu')

@section('content')
    @include('components.hero')
    @include('components.statistik')
    @include('components.kategori')
    @include('components.lowongan-terbaru')
    @include('components.cta')
@endsection