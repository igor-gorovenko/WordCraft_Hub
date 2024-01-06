<div class="bg-white p-4">
    <h4>Filters</h4>

    <div>
        <h6>Parts of Speech</h6>
        <form action="{{ route('filter') }}" method="GET">
            <div class="mb-4">
                @foreach($partOfSpeech as $part)
                <div class="form-check mb-1">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="selectedParts[]" value="{{ $part->name }}" {{ in_array($part->name, $selectedParts) ? 'checked' : '' }}>
                        {{ $part->name }}
                    </label>
                </div>
                @endforeach
            </div>
            <a href="{{ route('index') }}" class="btn btn-outline-danger">Reset</a>
            <button type="submit" class="btn btn-outline-dark">Apply</button>
        </form>
    </div>
</div>