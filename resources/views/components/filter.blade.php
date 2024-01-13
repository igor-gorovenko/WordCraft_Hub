<div class="bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4>Filters</h4>
        <a href="{{ route('index') }}" class="btn btn-outline-danger btn-sm">Reset</a>
    </div>
    <div>


        <form action="{{ route('filter') }}" method="GET">
            <!-- Фильтр по частям речи -->

            <div class="mb-4">
                <h6>Parts of Speech</h6>
                @foreach($partsOfSpeech as $part)
                <div class="form-check mb-1">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="parts[]" value="{{ $part->name }}" {{ in_array($part->name, $selectedParts) ? 'checked' : '' }}>
                        {{ $part->name }}
                    </label>
                </div>
                @endforeach
            </div>

            <!-- Фильтр по частоте -->
            <div class="mb-4">
                <h6>Frequency range</h6>
                @foreach($frequencyRange as $range)
                <div class="form-check mb-1">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="frequency_range[]" value="{{ $range }}" {{ in_array($range, $selectedFrequencyRange) ? 'checked' : '' }}>
                        {{ $range }}
                    </label>
                </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-outline-dark">Update List</button>

        </form>
    </div>
</div>