<div class="bg-white p-4">

    <!-- table header -->
    <div class="d-flex justify-content-between align-items-center mb-2">

        <h4>Result {{ count($words)}} words</h4>
        <div class="d-flex">
            <a href="{{ route('word.create') }}" class="btn btn-outline-dark me-2" type="submit">Add New Words</a>

            <form action="{{ route('export') }}" method="GET">
                <div>
                    <button class="btn btn-outline-dark" type="submit">Export to .csv</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Word</th>
                <th>Translate</th>
                <th>Frequency</th>
                <th>Part of speech</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="align-middle">
            @foreach( $words as $word)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $word->word }}</td>
                <td>{{ $word->translate }}</td>
                <td>{{ $word->frequency }}</td>
                <td>
                    @if($word->partOfSpeech)
                    {{ $word->partOfSpeech->name }}
                    @endif
                </td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('word.show', ['slug' => $word->slug]) }}" class="btn btn-outline-primary btn-sm me-2" target="_blank">View</a>
                        <form method="GET" action="{{ route('word.delete', ['slug' => $word->slug]) }}">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>