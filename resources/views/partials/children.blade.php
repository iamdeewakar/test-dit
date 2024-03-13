<!-- resources/views/partials/children.blade.php -->

<ul>
    @foreach ($children as $child)
        <li>{{ $child->name }}
            @if ($child->children->isNotEmpty())
                @include('partials.children', ['children' => $child->children])
            @endif
        </li>
    @endforeach
</ul>
