<div class="bg-white p-4">
    <h4>Filters</h4>

    @foreach($partOfSpeech as $part)
    <div>
        {{ $part->name }}
    </div>
    @endforeach
    <button type="submit" class="btn btn-outline-dark">Update List</button>

</div>