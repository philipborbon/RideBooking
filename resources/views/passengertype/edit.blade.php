@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Create New Passenger Type</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ action('PassengerTypeController@update', $id) }}">
    {{ csrf_field() }}

    <input name="_method" type="hidden" value="PATCH">

    <div class="row">
        <div class="col-6">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="control-label">Type</label>

            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $type->name) }}" required autofocus>

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
        <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
            <label for="discount" class="control-label">Discount (%)</label>

            <input id="discount" type="number" min="0" max="100" class="form-control" name="discount" value="{{ old('discount', $type->discount) }}" required autofocus>

            @if ($errors->has('discount'))
                <span class="help-block">
                    <strong>{{ $errors->first('discount') }}</strong>
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
