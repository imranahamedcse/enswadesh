@extends('layouts.backend.app')
@section('title','App area Create')
@push('css')
<link rel="stylesheet" href="{{ asset('css/dropify.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropify.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

<style>
.dropify-wrapper .dropify-message p {
    font-size: initial;
}
</style>
@endpush
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-photo-gallery icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>{{ __((isset($area) ? 'Edit' : 'Create New') . ' Area') }}</div>
        </div>
        <div class="page-title-actions">
            <div class="d-inline-block dropdown">
                <a href="{{ route('backend.areas.index') }}" class="btn-shadow btn btn-info">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                        <i class="fas fa-arrow-circle-left fa-w-20"></i>
                    </span>
                    {{ __('Back to list') }}
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-head"></div>
            <div class="card-body">
                <form action="{{ isset($area) ? route('backend.areas.update',$area->id) : route('backend.areas.store') }}" method="POST" enctype="multipart/form-data" file="true">
                    @csrf
                    @if (isset($area))
                    @method('PUT')
                    @endif
                    <div class="form-group">
                    <label for="name">Area Name</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ isset($area) ? $area->name : '' }}"  placeholder="Area name">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                    <div class="form-group">
                    <label for="city_id">Cities</label>
                    @if(isset($area))
                    <select name="city_id" id="city_id" class="form-control">
                        <option value="">Select One</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ $area->city_id == $city->id ? 'selected' : ''}}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @else
                    <select name="city_id" id="city_id" class="form-control">
                        <option value="">Select One</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @endisset
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                    <div class="form-group">
                    <label for="description">area Description</label>
                    <input type="text" id="description" name="description" class="form-control" value="{{ isset($area) ? $area->description : '' }}" placeholder="Area Description">
                    </div>
                    <div class="form-group">
                    <label for='icon'>Area Icon</label>
                    <input type="file" id="icon" name="icon" class="dropify" data-default-file="{{ isset($area) ? asset($area->icon): '' }}" data-height="220" value="{{ isset($area) ? asset($area->icon): '' }}" />
                    @error('icon')
                    <span class="invalid-feedback image-display-error-message" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                    <button class="btn btn-danger" on-click="resetForm('userFrom')"><i class="fas fa-redo"></i> Reset</button>
                    @isset($area)
                    <button type="submit" class="btn btn-info"><i class="fas fa-arrow-circle-up"></i> Update</button>
                    @else
                    <button type="submit" class="btn btn-info"><i class="fas fa-plus-circle"></i> Create</button>
                    @endisset
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('js/dropify.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
$(document).ready(function() {
    // Dropify
    $('.dropify').dropify();
    // Select2
    $('.select').each(function() {
        $(this).select2();
    });
});
</script>
@endpush
