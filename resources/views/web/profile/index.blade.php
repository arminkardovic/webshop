@extends('web.layout')

@section("content")
    <section class="profile">

        <div class="container">

            <h2>My Dashboard</h2>

            <div class="row">

                <ul class="nav nav-tabs col-md-3" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#profile" role="tab" aria-controls="home">Moji
                            podaci </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#orders" role="tab" aria-controls="profile">Moji
                            orderi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#favorites" role="tab" aria-controls="messages">Favorites </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#gift" role="tab" aria-controls="settings">gift
                            card/account balance</a>
                    </li>
                </ul>

                <div class="tab-content col-md-9">
                    @include("web.profile.edit", [])
                    @include("web.profile.orders", [])
                    @include("web.profile.favorites", [])
                    @include("web.profile.gift", [])
                </div>

            </div>

        </div>

    </section>
@endsection