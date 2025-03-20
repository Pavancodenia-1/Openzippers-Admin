@extends('admin.layout.main')

@section('admin-page-title', ucfirst($mode ?? 'Wallet'))

@section('admin-main-section')


<!-- PAGE-HEADER -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">{{ ucfirst($mode ?? 'Wallet') }}</h1>

        <!-- @if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->user_role<= 1)
                <a href="{{ route('admin.posts.create') }}"><x-buttons.simple-button class="btn btn-primary" type="button">Add
                        Post</x-buttons.simple-button></a>
            @endif
             -->
    </div>
</div>
<!-- PAGE-HEADER END -->



<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Balance Added by Admin</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottomm" id="file-datatable">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">User's name</th>
                                <th class="wd-20p border-bottom-0">Admin name</th>
                                <th class="wd-15p border-bottom-0">wallet Id</th>
                                <th class="wd-15p border-bottom-0">Added Amount</th>
                                <th class="wd-15p border-bottom-0">Balance Before</th>
                                <th class="wd-15p border-bottom-0">Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($wallets as $wallet)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ optional($wallet->user)->name ?: 'N/A' }}</td>
                                <td>{{ optional($wallet->admin)->name ?: 'N/A' }}</td>
                                <td>{{ $wallet->wallet_id ?: 'N/A' }}</td>
                                <td>{{ number_format($wallet->amount, 2) ?: '0.00' }}</td>
                                <td>{{ number_format($wallet->balance_before, 2) ?: '0.00' }}</td>
                                <td>{{ $wallet->updated_at }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No wallet records found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

@endsection

@section('custom-script')
<!-- DATA TABLE JS-->
<script src="{{ asset('../assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('../assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('../assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('../assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('../assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('../assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('../assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('../assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('../assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('../assets/js/table-data.js') }}"></script>
@endsection