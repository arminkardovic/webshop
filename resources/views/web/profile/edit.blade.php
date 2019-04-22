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
        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" data-show-content="true" name="gender" class="form-control border">
                <option value="">Select</option>
                <option value="1" @if(isset($user->gender) && $user->gender == 1) selected @endif>Men</option>
                <option value="2" @if(isset($user->gender) && $user->gender == 2) selected @endif>Women</option>
            </select>
        </div>
        <div class="form-group">
            <label for="location_settings_id">Country</label>
            <select id="location_settings_id" data-show-content="true" name="location_settings_id" class="form-control border">
                @foreach($countries as $country)
                    <option {{$user->location_settings_id == $country->id ? ' selected' : ''}} value="{{$country->id}}">{{$country->country}}</option>
                @endforeach
            </select>
        </div>




        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
