<div class="bg-light p-4">
    <form action="{{ route('export') }}" method="GET">
        <div>
            <label>Tags</label>
        </div>
        @foreach ($tags as $tag)
        <label>
            <input type="checkbox" name="tags[]" value="{{ $tag->name }}" @if(in_array($tag->name, $selectedTags)) checked @endif>
            {{ $tag->name }}
        </label>
        @endforeach
        <div>
            <button type="submit">Export</button>
        </div>
    </form>
</div>