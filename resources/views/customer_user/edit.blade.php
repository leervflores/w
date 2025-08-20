@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Customer User</h3>

    <form action="{{ route('customer_user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" value="{{ $user->full_name }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" value="{{ $user->phone_number }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Profile Photo</label>
            <input type="file" name="photo" class="form-control">
            @if($user->photo ?? false)
                <img src="{{ asset('storage/'.$user->photo) }}" alt="Profile" class="mt-2" width="80">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('customer_user.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
