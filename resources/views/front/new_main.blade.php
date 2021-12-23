@extends('front.layout')

@section('content')

    @include('front.main.calculator')
    @include('front.main.steps')
    @include('front.main.tariffs')
    @include('front.main.stores')
    @include('front.main.articles')
    @include('front.main.app')
    @include('front.main.json')

@endsection