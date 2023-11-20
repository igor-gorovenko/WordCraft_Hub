<table class="table">
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
        @foreach($words->sortByDesc('usage_count') as $word)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td><a href="{{ route('show', ['id' => $word->id]) }}">{{ $word->word }}</a></td>
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