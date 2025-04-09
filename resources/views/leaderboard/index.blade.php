<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
    <div class="container">
        <h1 class="mb-4">Leaderboard</h1>
    
        <form method="GET" action="{{ route('leaderboard.index') }}" class="row g-3 mb-4">
            <div class="col-md-3">
                <input type="text" name="user_id" class="form-control" placeholder="Search by User ID" value="{{ request('user_id')}}">
            </div>
            <div class="col-md-3">
                <select name="filter" class="form-select">
                    <option value="">All</option>
                    <option value="day" {{ request('filter') == 'day' ? 'selected' : '' }}>Today</option>
                    <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>This Month</option>
                    <option value="year" {{ request('filter') == 'year' ? 'selected' : '' }}>This Year</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Total Points</th>
                    <th>Rank</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->total_points }}</td>
                        <td>{{ $user->rank }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    
        <form method="POST" action="{{ route('leaderboard.recalculate') }}">
            @csrf
            <button type="submit" class="btn btn-warning">Recalculate</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

