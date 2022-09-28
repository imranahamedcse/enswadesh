@extends('layouts.backend.app')

@section('title','Area')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-photo-gallery icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>{{ __('Order Calculate') }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    {{-- {{ $members }} --}}
                    <table id="datatableArea" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            {{-- <th scope="col">Canceled</th> --}}
                            <th scope="col">Pending</th>
                            {{-- <th scope="col">Processing</th>
                            <th scope="col">Delivery</th>
                            <th scope="col">Complete</th>
                            <th scope="col">Refund</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $key => $member)
                            <tr>
                                <th scope="row">{{ ++$key }}</th>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->phone_number }}</td>
                                {{-- <td>{{ App\Models\Delivery\OrderCalculate::cancel($member->id) }}</td> --}}
                                <td>{{ App\Models\Delivery\OrderCalculate::pending($member->id) }}</td>
                                {{-- <td>{{ App\Models\Delivery\OrderCalculate::processing($member->id) }}</td>
                                <td>{{ App\Models\Delivery\OrderCalculate::delivery($member->id) }}</td>
                                <td>{{ App\Models\Delivery\OrderCalculate::complete($member->id) }}</td>
                                <td>{{ App\Models\Delivery\OrderCalculate::refund($member->id) }}</td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Datatable
            $("#datatableArea").DataTable();
        });
    </script>
@endpush
