<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
</head>
<body>
    <form action="{{ route('search') }}" method="GET">
        <input type="text" name="query" placeholder="Search..." required>
        <button type="submit">Search</button>
    </form>
</body>
</html>
