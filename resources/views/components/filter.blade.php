<div class="bg-light p-4">
    <p>Tags</p>
    <form action="{{ route('filterTags') }}" method="post">
        @csrf
        @foreach ($tags as $tag)
        <label>
            <input type="checkbox" name="tags[]" value="{{ $tag->name }}" @if(in_array($tag->name, $selectedTags)) checked @endif>
            {{ $tag->name }}
        </label>
        @endforeach
        <button type="submit" class="btn btn-primary">Применить фильтр</button>
    </form>
</div>