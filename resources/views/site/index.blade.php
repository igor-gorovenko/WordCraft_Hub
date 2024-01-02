@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-3">
        @include('components/filter')
    </div>
    <div class="col-9">
        @include('components/table')
    </div>

</div>

@endsection