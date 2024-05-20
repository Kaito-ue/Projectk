<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Example</title>
</head>
<body>
    <h1>Search</h1>
    <form action="{{ route('search') }}" method="GET">
        <input type="text" name="query" placeholder="Enter search term">
        <button type="submit">Search</button>
    </form>
    
    @if(isset($results))
        <h2>Search Results:</h2>
        @if($results->isEmpty())
            <p>No results found.</p>
        @else
            <ul>
                @foreach($results as $result)
                    <li>{{ $result->name }}</li>
                @endforeach
            </ul>
        @endif
    @endif
</body>
</html>
