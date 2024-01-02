<div class="bg-white p-4">
    <table class="table">
        <h4>All words</h4>
        <thead>
            <tr>
                <th>#</th>
                <th>Word</th>
                <th>Translate</th>
                <th>Usage Count</th>
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
            </tr>
            @endforeach
        </tbody>
    </table>
</div>