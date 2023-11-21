<div class="bg-light p-4">
    <p>Tags</p>
    <form action="{{ route('filterTags') }}" method="get">
        @foreach ($tags as $tag)
        <label>
            <input type="checkbox" name="tags[]" value="{{ strtolower($tag->name) }}" @if(in_array(strtolower($tag->name), $selectedTags)) checked @endif>
            {{ $tag->name }}
        </label>
        @endforeach
        <button type="submit" class="btn btn-primary">Применить фильтр</button>
    </form>
</div>