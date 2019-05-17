@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Create New Wallet</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ url('wallets') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('userid') ? ' has-error' : '' }}">
        <label for="userid" class="control-label">User</label>

        <select id="userid" class="form-control" name="userid" autofocus>
          @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('userid') == $user->id ? 'selected' : '' }}>{{ $user->getFullname() }}</option>
          @endforeach
        </select>

        @if ($errors->has('userid'))
            <span class="help-block">
                <strong>{{ $errors->first('userid') }}</strong>
            </span>
        @endif
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                <label for="amount" class="control-label">Amount</label>

                <input id="amount" type="number" step="0.01" min="0" class="form-control" name="amount" value="{{ old('amount') }}" required autofocus>

                @if ($errors->has('amount'))
                    <span class="help-block">
                        <strong>{{ $errors->first('amount') }}</strong>
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
