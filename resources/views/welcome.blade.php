@extends('web.layout')

@section("content")
    @include("web.homepage.main-slideshow", [])
    @include("web.homepage.slogan", [])
    @include("web.homepage.categories-block", [])
@endsection