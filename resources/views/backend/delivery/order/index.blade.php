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
                <div>{{ __('Order Status') }}</div>
            </div>
            {{-- <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('backend.delivery-member-assign.create') }}" class="btn-shadow btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fas fa-plus-circle fa-w-20"></i>
                        </span>
                        {{ __('Assign member') }}
                    </a>
                </div>
            </div> --}}
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
                            <th scope="col">Order No</th>
                            <th scope="col">Client Phone</th>
                            <th scope="col">Client Name</th>
                            <th scope="col">Market Name</th>
                            <th scope="col">Shop Name</th>
                            <th scope="col">Collect by</th>
                            <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $key => $order)
                            <tr>
                                <th scope="row">{{ ++$key }}</th>
                                <td>{{ $order->order_no }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->phone_number }}</td>
                                <td>{{ $order->market_name }}</td>
                                <td>{{ $order->shop_name }} ({{ $order->shop_no }})</td>
                                <td>{{ App\Models\Delivery\OrderCalculate::name($order->market_id) }}</td>
                                <td>
                                    @if ($order->order_status == 0)
                                        Canceled
                                    @elseif ($order->order_status == 1)
                                        Pending
                                    @elseif ($order->order_status == 2)
                                        Processing
                                    @elseif ($order->order_status == 3)
                                        Delivery
                                    @elseif ($order->order_status == 4)
                                        Complete
                                    @elseif ($order->order_status == 5)
                                        Refund
                                    @endif
                                </td>
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
