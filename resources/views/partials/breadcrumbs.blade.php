@if (count($breadcrumbs))
    <ol class="breadcrumb text-truncate">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item text-truncate"><a class="bread_link" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li class="breadcrumb-item active text-truncate">{{ $breadcrumb->title }}</li>
            @endif

        @endforeach
    </ol>

@endif