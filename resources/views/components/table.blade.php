<div class="bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4>All words</h4>
        <div class="d-flex">
            <a href="{{ route('word.create') }}" class="btn btn-outline-success me-2" type="submit">Add word</a>

            <form action="{{ route('export') }}" method="GET">
                <div>
                    <button class="btn btn-outline-dark" type="submit">Export</button>
                </div>
            </form>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Word</th>
                <th>Translate</th>
                <th>Usage Count</th>
                <th>Parts of speech</th>
            </tr>
        </thead>
        <tbody>
            @php
            // Сортировка слов по убыванию частоты использования
            $sortedWords = $words->sortByDesc('usage_count');
            @endphp

            @foreach( $sortedWords as $word)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $word->word }}</td>
                <td>{{ $word->translate }}</td>
                <td>{{ $word->usage_count }}</td>
                <td>
                    @if($word->partsOfSpeech)
                    @foreach($word->partsOfSpeech as $partOfSpeech)
                    {{ $partOfSpeech->name }},
                    @endforeach
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>