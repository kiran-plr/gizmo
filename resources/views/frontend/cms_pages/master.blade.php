@extends('frontend.layouts.master')

@section('content')
    @include('frontend.cms_pages.' . $slug)
@endsection
