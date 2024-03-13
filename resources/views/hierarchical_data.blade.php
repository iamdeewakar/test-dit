<!-- resources/views/hierarchical_data.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hierarchical Data</title>
    <style>
        ul {
            list-style-type: none;
        }

        ul ul {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <h1>Hierarchical Data</h1>
    <ul>
        @foreach ($rootPeople as $person)
            <li>{{ $person->name }}
                @if ($person->children->isNotEmpty())
                    @include('partials.children', ['children' => $person->children])
                @endif
            </li>
        @endforeach
    </ul>
</body>
</html>
