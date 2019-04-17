<div class="tab-pane active" id="profile" role="tabpanel">
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    @if(session()->has('warning'))
        <div class="alert alert-warning">
            {{ session()->get('warning') }}
        </div>
    @endif
    <form method="POST" action="{{ route('update-profile') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="firstname">First name</label>
            <input type="text" class="form-control" id="firstname" name="first_name" value="{{$user->first_name}}">
        </div>

        <div class="form-group">
            <label for="lastname">Last name</label>
            <input type="text" class="form-control" id="lastname" name="last_name" value="{{$user->last_name}}">
        </div>

        <div class="form-group">
            <label for="Email">Email</label>
            <input type="email" class="form-control" id="Email" name="email" value="{{$user->email}}">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" autocomplete="off" class="form-control" id="Password" name="password">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="{{$user->address}}">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
