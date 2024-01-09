@extends('layouts.app')

@section('content')

<div class="bg-white p-4">
    <div class="mb-2">
        <a href="{{ route('index') }}">Back</a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4>Show</h4>
    </div>

    <div class="container">
        <table class="table">
            <tbody>
                <tr>
                    <th scope="row">Word:</th>
                    <td>{{ $word->word }}</td>
                </tr>
                <tr>
                    <th scope="row">Translation:</th>
                    <td>{{ $word->translate }}</td>
                </tr>
                <tr>
                    <th scope="row">Frequency:</th>
                    <td>{{ $word->frequency }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection