@extends('web.layout')

@section("content")

    @include("web.checkout.content", ['cart' => $cart])

@endsection