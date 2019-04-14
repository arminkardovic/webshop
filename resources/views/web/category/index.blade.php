@extends('web.layout')

@section("content")

@include("web.category.products", ['category' => $category, 'products' => $products, 'attributes' => $attributes])

@endsection