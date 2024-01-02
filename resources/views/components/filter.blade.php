<div class="bg-white p-4">
    <h4>Filters</h4>
    <form action="{{ route('export') }}" method="GET">
        <div>
            <label>Tags</label>
        </div>
        @foreach ($tags as $tag)
        <div>
            <label>
                <input type="checkbox" name="tags[]" value="{{ $tag->name }}" @if(in_array($tag->name, $selectedTags)) checked @endif>
                {{ $tag->name }}
            </label>
        </div>
        @endforeach
        <div>
            <button class="btn btn-outline-dark" type="submit">Export</button>
        </div>
    </form>
</div>