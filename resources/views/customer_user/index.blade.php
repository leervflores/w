<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">Customer Users</a>
</nav>

<div class="container mt-3">

    <!-- Back Button -->
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">
        &larr; Back
    </a>

    <h2 class="mb-4 text-center">Customer Users</h2>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    {{-- Users Table --}}
    <div class="card shadow">
        <div class="card-body">
            @if($users->isEmpty())
                <p class="text-center text-muted">No customer users found.</p>
            @else
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->full_name ?? $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('customer_user.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
