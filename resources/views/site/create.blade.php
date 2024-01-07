@extends('layouts.app')

@section('content')


<div class="bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4>Create word</h4>
    </div>

    <form action="{{ route('word.store') }}" method="post">
        @csrf
        <label for="wordList">Word:</label>
        <div>
            <textarea name="wordList" rows="5" placeholder="Enter words"></textarea>
        </div>


        <button class="btn btn-outline-dark" type="submit">Create words</button>

    </form>

</div>


@endsection