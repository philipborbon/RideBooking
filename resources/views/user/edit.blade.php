@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Edit User</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{action('UserController@update', $id)}}">
      {{ csrf_field() }}

      <input name="_method" type="hidden" value="PATCH">

      <div class="row">

        <div class="col">
        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
            <label for="firstname" class="control-label">First Name</label>

            <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname', $user->firstname) }}" required autofocus>

            @if ($errors->has('firstname'))
                <span class="help-block">
                    <strong>{{ $errors->first('firstname') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col">
        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
            <label for="lastname" class="control-label">Last Name</label>

            <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname', $user->lastname) }}" required autofocus>

            @if ($errors->has('lastname'))
                <span class="help-block">
                    <strong>{{ $errors->first('lastname') }}</strong>
                </span>
            @endif
        </div>
      </div>
    </div>

    <div class="row">
    <div class="col-6">
    <div class="form-group">
        <label>E-Mail Address</label>

        <input
                type="email"
                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                name="email"
                value="{{ old('email', $user->email) }}"
                required
        >

        @if ($errors->has('email'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </div>
        @endif
    </div>
    </div>
    </div>

    <div class="row">
    <div class="col-6">
    <div class="form-group">
        <label>Password</label>

        <input
                type="password"
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="password"
        >
        @if ($errors->has('password'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </div>
        @endif
    </div>
    </div>
    <div class="col-6">
    <div class="form-group">
        <label>Confirm Password</label>

        <input
                type="password"
                class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                name="password_confirmation"
        >
        @if ($errors->has('password_confirmation'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </div>
        @endif
    </div>
    </div>
    </div>

    <div class="row">
        <div class="col-12"><p>Note: Don't fill out the password if you don't want to update your password.</p></div>
    </div>

    <div class="row">
    <div class="col-6">
    <div class="form-group{{ $errors->has('usertype') ? ' has-error' : '' }}">
        <label for="usertype" class="control-label">User Type</label>

        <select id="usertype" class="form-control" name="usertype" autofocus>
          @foreach(config('enums.usertype') as $key => $value)
            <option value="{{ $key }}" {{ old('usertype', $user->usertype) == $key ? 'selected' : '' }}>{{ $value }}</option>
          @endforeach
        </select>

        @if ($errors->has('usertype'))
            <span class="help-block">
                <strong>{{ $errors->first('usertype') }}</strong>
            </span>
        @endif
    </div>
    </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </div>
  </form>
</div>
@endsection
