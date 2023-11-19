@extends('app')

@section('content')
<div class="container">
    <h1>WordCraft Hub</h1>
    @include('components/filter')
    @include('components/table')

</div>
@endsection