@extends('admin.layout.main')

@section('admin-page-title', ucfirst($mode ?? 'Manage Posts'))

@section('admin-main-section')

<style>
    .truncate {
        width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
        position: relative;
        display: inline-block;
    }

    .truncate:hover {
        white-space: normal;
        overflow: visible;
        padding: 5px;
    }
</style>

<!-- PAGE-HEADER -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">{{ ucfirst($mode ?? 'Manage Posts') }}</h1>

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
                <h3 class="card-title">All Posts</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottomm" id="file-datatable">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">Sender Name</th>
                                <th class="wd-20p border-bottom-0">Receiver Name</th>
                                <th class="wd-15p border-bottom-0">Subscription Id</th>
                                <th class="wd-15p border-bottom-0">Post Id</th>
                                <th class="wd-15p border-bottom-0">Stripe Transaction Id</th>
                                <th class="wd-15p border-bottom-0">Invoice Id</th>
                                <th class="wd-15p border-bottom-0">Stream Id</th>
                                <th class="wd-15p border-bottom-0">Message Id</th>
                                <th class="wd-15p border-bottom-0">Unlock Type</th>
                                <th class="wd-15p border-bottom-0">Video Call Id</th>
                                <th class="wd-15p border-bottom-0">Status</th>
                                <th class="wd-15p border-bottom-0">Audio Call Id</th>
                                <th class="wd-15p border-bottom-0">Type</th>
                                <th class="wd-15p border-bottom-0">Chat Id</th>
                                <th class="wd-15p border-bottom-0">Payment Provider</th>
                                <th class="wd-15p border-bottom-0">Artist Amount</th>
                                <th class="wd-15p border-bottom-0">Created At</th>
                                <th class="wd-25p border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaction->sender->name ?? " "}}</td>
                                <td>{{ $transaction->receiver->name ?? " " }}</td>
                                <td>{{ $transaction->subscription_id }}</td>
                                <td>{{ $transaction->post_id }}</td>
                                <td>{{ $transaction->stripe_transaction_id }}</td>
                                <td>{{ $transaction->invoice_id }}</td>
                                <td>{{ $transaction->stream_id }}</td>
                                <td>{{ $transaction->message_id }}</td>
                                <td>{{ $transaction->unlock_type }}</td>
                                <td>{{ $transaction->video_call_id }}</td>
                                <td>{{ $transaction->status }}</td>
                                <td>{{ $transaction->audio_call_id }}</td>
                                <td>{{ $transaction->type }}</td>
                                <td>{{ $transaction->chat_id }}</td>
                                <td>{{ $transaction->payment_provider }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->created_at }}</td>
                                <td class="text-center">
                                    <x-buttons.action-pill-button iconClass="fa fa-eye" iconColor="secondary"
                                        href="{{ route('admin.transaction.view', $transaction->id) }}" />

                                    @if (Auth::guard('admin')->user()->user_role
                                    <= 1)
                                        <x-buttons.action-pill-button
                                        href="{{ route('admin.transaction.edit', $transaction->id) }}"
                                        iconClass="fa fa-pencil" iconColor="warning"
                                        modalTarget="editUserModal" />
                                    @endif

                                    @if (Auth::guard('admin')->user()->user_role <= 1)
                                        <form action="{{ route('admin.transaction.destroy', $transaction->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-buttons.action-pill-button type="submit" iconClass="fa fa-trash"
                                            iconColor="danger" />
                                        </form>
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