<table class="table">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Word</th>
            <th>Translation</th>
            <th>Usage Count</th>
            <th>Usage %</th>
        </tr>
    </thead>
    <tbody>
        @foreach($words->sortByDesc('usage_count') as $word)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $word->word }}</td>
            <td>{{ $word->translation }}</td>
            <td>{{ $word->usage_count }}</td>
            <td>{{ number_format(($word->usage_count / $loop->count) / 100, 2) }} %</td>
        </tr>
        @endforeach
    </tbody>
</table>