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
            <div>{{ __((isset($member) ? 'Edit' : 'Add') . ' Member') }}</div>
        </div>
        <div class="page-title-actions">
            <div class="d-inline-block dropdown">
                <a href="{{ route('backend.delivery-member-assign.index') }}" class="btn-shadow btn btn-info">
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
                <form action="{{ isset($member) ? route('backend.delivery-member-assign.update',$member->id) : route('backend.delivery-member-assign.store') }}" method="POST" enctype="multipart/form-data" file="true">
                    @csrf
                    @if (isset($member))
                        @method('PUT')
                    @endif
                    
                    <div class="form-group">
                        <label for="user_id">Memeber</label>
                        @if(isset($member))
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="" disabled>Select</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $member->user_id == $user->id ? 'selected' : ''}}>{{ $user->name }} ({{ $user->phone_number }})</option>
                                @endforeach
                            </select>
                        @else
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="" disabled selected>Select</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->phone_number }})</option>
                                @endforeach
                            </select>
                        @endisset
                        {{-- @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}
                    </div>
                    <div class="form-group">
                        <label for="market_id">Markets</label>
                        @if(isset($member))
                            <select name="market_id" id="market_id" class="form-control">
                                <option value="" disabled>Select</option>
                                @foreach($markets as $market)
                                    <option value="{{ $market->id }}" {{ $member->market_id == $market->id ? 'selected' : ''}}>{{ $market->name }} ({{ $market->address }})</option>
                                @endforeach
                            </select>
                        @else
                            <select name="market_id" id="market_id" class="form-control">
                                <option value="" disabled selected>Select</option>
                                @foreach($markets as $market)
                                    <option value="{{ $market->id }}">{{ $market->name }} ({{ $market->address }})</option>
                                @endforeach
                            </select>
                        @endisset
                        {{-- @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" id="description" name="description" class="form-control" value="{{ isset($member) ? $member->description : '' }}" placeholder="Description">
                    </div>
                    @isset($member)
                        <button type="submit" class="btn btn-info"><i class="fas fa-arrow-circle-up"></i> Update</button>
                    @else
                        <button type="submit" class="btn btn-info"><i class="fas fa-plus-circle"></i> Add</button>
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
