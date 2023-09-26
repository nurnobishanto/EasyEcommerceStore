@extends('layouts.front')
@section('content')
    <section class="mb-lg-14 mb-8 mt-8">
        <div class="container">
            <h2 class="text-center">{!! $title !!}</h2>
            <p>{!! $content !!}</p>
        </div>
    </section>
@endsection
