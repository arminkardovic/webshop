<main class="register-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form name="login-form" onsubmit="return validform()" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" placeholder="Your Password *" value="" name="password"/>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    LOGIN
                                </button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row justify-content-center sign-up">
            <div class="col-md-8">
                <div class="block block-new-customer">
                    <div class="block-title">
                        <strong id="block-new-customer-heading" role="heading" aria-level="2">New Customers</strong>
                    </div>
                    <div class="block-content" aria-labelledby="block-new-customer-heading">
                        <p>Creating an account has many benefits: check out faster, keep more than one address, track orders and more.</p>
                        <div class="actions-toolbar">
                            <button type="submit" class="btn btn-primary" onclick="window.location.replace('{{route('register')}}')">
                                REGISTER
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>