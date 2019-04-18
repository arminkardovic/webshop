<main class="register-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form name="my-form" onsubmit="return validform()" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="form-group row{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">First name</label>
                                <div class="col-md-6">
                                    <input type="text" id="first_name" class="form-control" name="first_name">
                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">Last name</label>
                                <div class="col-md-6">
                                    <input type="text" id="last_name" class="form-control" name="last_name">
                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="email" id="email_address" class="form-control" name="email">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('gender') ? ' has-error' : '' }}">

                                <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>
                                <div class="col-md-6">
                                    <select id="gender" data-show-content="true" name="gender" class="form-control border">
                                        <option value="">Select</option>
                                        <option value="1">Men</option>
                                        <option value="2">Women</option>
                                    </select>
                                    @if ($errors->has('gender'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
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

                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">Confirm Password </label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" placeholder="Confirm Password *" value="" name="password_confirmation"/>
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="permanent_address" class="col-md-4 col-form-label text-md-right">Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="permanent_address" class="form-control" name="address">
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                    </form>
                </div>
                    <div class="social-sign-up">

                        <h4>Sign up with...</h4>

                        <div class="social-links-container">
                            <a href="#" id="signup-facebook" class="social-link facebook">
                                <div class="connect facebook qa-sign-up-with-facebook" aria-label="Facebook">
                                    <i class="fab fa-facebook"></i>
                                    <div class="text"><span>Facebook</span></div>
                                </div>
                            </a>
                            <a href="#" id="signup-google" class="social-link gplus">
                                <div class="connect google qa-sign-up-with-google" aria-label="Google">
                                    <i class="fab fa-google"></i>
                                    <div class="text"><span>Google</span></div>
                                </div>
                            </a>
                            <a href="#" id="signup-twitter" class="social-link twitter">
                                <div class="connect twitter qa-sign-up-with-twitter" aria-label="Twitter">
                                    <i class="fab fa-twitter-square"></i>
                                    <div class="text"><span>Twitter</span></div>
                                </div>
                            </a>
                        </div>

                    </div>
            </div>
        </div>
    </div>
    </div>

</main>