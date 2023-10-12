@extends('frontend.layouts.master')
@section('content')
    <section class="product-list-wrapper">
        <livewire:frontend.sell-iphone :category="$category" :brand="$brand" />
    </section>

    @include('frontend.partials.certificate-quality')

    @include('frontend.partials.offer')

    @include('frontend.partials.reviews')
@endsection
