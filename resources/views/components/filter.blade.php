<div class="bg-light p-4">
    <p>Tags</p>
        @foreach ($tags as $tag)
        <label>
            <input type="checkbox" name="tags[]" value="{{ strtolower($tag->name) }}" @if(in_array(strtolower($tag->name), $selectedTags)) checked @endif>
            {{ $tag->name }}
        </label>
        @endforeach
</div>
