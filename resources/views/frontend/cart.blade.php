@extends('frontend.layouts.master')
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <livewire:frontend.my-cart :data="$data" />
                </div>
            </div>
        </div>
    </section>
@endsection
