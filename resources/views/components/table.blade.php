<div class="bg-white p-4">
    <table class="table">
        <h4>All words</h4>
        <thead>
            <tr>
                <th>#</th>
                <th>Word</th>
                <th>Translation</th>
                <th>Usage Count</th>
                <th>Usage %</th>
                <th>Tags</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $words->sortByDesc('usage_count') as $word)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $word->word }}</td>
                <td>{{ $word->translation }}</td>
                <td>{{ $word->usage_count }}</td>
                <td>{{ number_format(($word->usage_count / $loop->count) / 100, 2) }} %</td>
                <td>
                    @foreach($word->tags as $tag)
                    {{ $tag->name }}
                    @unless($loop->last)
                    ,
                    @endunless
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>