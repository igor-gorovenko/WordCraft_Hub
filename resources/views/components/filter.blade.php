<p>Tags</p>

<div class="bg-light">
    @foreach($tags as $tag)
    <span class="badge text-bg-primary">
        {{ $tag->name }}
    </span>
    @endforeach
</div>