<!DOCTYPE html>
<html>
<head>
    <title>SuperAdmin Dashboard</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { display: inline; }
        nav ul { list-style: none; padding: 0; display: flex; gap: 15px; }
        nav ul li { display: inline; }
    </style>
</head>
<body>

<nav>
    <ul>
        <li><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('customer_user.index') }}">Customer Users</a></li>
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </li>
    </ul>
</nav>

<h1>SuperAdmin Dashboard</h1>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

<!-- Users Section -->
<h2>Users</h2>
<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Actions</th>
</tr>
@foreach($users as $user)
<tr>
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->role }}</td>
    <td>
        <a href="#">Edit</a>
        <form action="{{ route('superadmin.destroy', $user->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</table>

</body>
</html>
