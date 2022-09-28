@extends('layouts.backend.app')

@section('title','Tutorial')
@push('css')
<link rel="stylesheet" href="{{ asset('css/dropify.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropify.min.css') }}">

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
                <i class="pe-7s-check icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>{{ isset($tutorial) ? 'Edit' : 'Create New' }} Tutorial</div>
        </div>
        <div class="page-title-actions">
            <div class="d-inline-block dropdown">
                <a href="{{ route('backend.tutorial.index') }}" class="btn-shadow btn btn-danger">
                    <span class="btn-icon-wrapper pr-2 opacity-7">
                        <i class="fas fa-arrow-circle-left fa-w-20"></i>
                    </span>
                    Back to list
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="main-card mb-3 card">
            <!-- form start -->
            <form id="tutorialFrom" role="form" method="POST"
                action="{{ isset($tutorial) ? route('backend.tutorial.update',$tutorial->id) : route('backend.tutorial.store') }}"
                enctype="multipart/form-data" file="true">
                @csrf
                @if (isset($tutorial))
                @method('PUT')
                @endif
                <div class="card-body">
                    <h5 class="card-title">Tutorial</h5>
                    <div class="form-group">
                        <br>
                        <Label for='title'>Title</Label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                            name="title" value="{{ $tutorial->title ?? old('title') }}" autofocus>

                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <br>
                        <Label for='link'>Link</Label>
                        <input id="link" type="url" class="form-control @error('link') is-invalid @enderror"
                            name="link" value="{{ $tutorial->link ?? old('link') }}" autofocus>

                        @error('link')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <Label for='description'>Description</Label>
                        <input id="description" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="description" value="{{ $tutorial->description ?? old('description') }}" autofocus>

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button type="button" class="btn btn-danger" onClick="resetForm('tutorialFrom')">
                        <i class="fas fa-redo"></i>
                        <span>Reset</span>
                    </button>

                    <button type="submit" class="btn btn-primary">
                        @isset($tutorial)
                        <i class="fas fa-arrow-circle-up"></i>
                        <span>Update</span>
                        @else
                        <i class="fas fa-plus-circle"></i>
                        <span>Create</span>
                        @endisset
                    </button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('js/dropify.min.js') }}"></script>
<script>
$(document).ready(function() {
    // Dropify
    $('.dropify').dropify();
});
</script>
@endpush
