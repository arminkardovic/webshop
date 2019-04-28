@extends('backpack::layout')

@section('content-header')
    <section class="content-header">
        <h1>
            <span>{{ trans('currency.exchange_rate') }}</span>
        </h1>
    </section>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 well">
            <h2>{{trans('currency.exchange_rate')}}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span>{{trans('currency.exchange_rate')}}</span>
                    </h3>
                </div>
                <div class="box-body">
                    <div>
                        <form name="currency-form" method="POST"
                              action="{{ route('exchange-rates-update') }}">
                            {{ csrf_field() }}
                            {{ trans('currency.usd-eur') }}: <input type="number" step=".00001" class="form-control" type="text" name="usdExchange" value="{{$usdExchange}}">
                            <br>
                            {{ trans('currency.rsd-eur') }}: <input type="number" step=".00001" class="form-control" type="text" name="rsdExchange" value="{{$rsdExchange}}">
                            <br>
                            <button type="submit" class="form-control btn-success">{{trans('currency.save')}}</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        </div>
    </div>



@endsection


@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/show.css') }}">

    <!-- include select2 css-->
    <link href="{{ asset('vendor/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Select 2 Bootstrap theme -->
    <link href="{{ asset('css/select2-bootstrap-min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/show.js') }}"></script>

    <!-- include select2 js -->
    <script src="{{ asset('vendor/adminlte/plugins/select2/select2.min.js') }}"></script>

    <script>
        $(document).ready(function () {

        });
    </script>
@endsection