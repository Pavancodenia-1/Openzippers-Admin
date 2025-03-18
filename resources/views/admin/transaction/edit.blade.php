@extends('admin.layout.main')

@section('admin-page-title', ucfirst($mode ?? 'create') . ' Post')

@section('admin-main-section')

<!-- PAGE-HEADER -->
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">{{ ucfirst($mode ?? 'create') }} Transaction</h1>
    </div>
</div>
<!-- PAGE-HEADER END -->



<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ ucfirst($mode ?? 'create') }} Transaction</h3>
            </div>
            <div class="card-body">
                @if ($mode == 'edit' || $mode == 'create')
                <form method="POST"
                    action="{{ $mode == 'create' ? route('admin.transaction.store') : route('admin.transaction.update', $transactions->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @if ($mode == 'edit')
                    @method('PUT')
                    @endif
                    @endif

                    <div class="form-row">

                        <div class="col-xl-12">
                            <div class="row">

                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="sender_name">Sender Name</label>
                                    <p class="form-control">{{ $transactions->sender->name }}</p>
                                </div>

                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="receiver_name">Receiver Name</label>
                                    <p class="form-control">{{ $transactions->receiver->name }}</p>
                                </div>

                                @if ($mode == 'create' || $mode == 'edit')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Subscription Id" name="subscription_id"
                                    type="text" :value="old('subscription_id', $mode == 'edit' ? $transactions->subscription_id : '')" />
                                @elseif($mode == 'view')
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="subscription_id">Subscription Id</label>
                                    <p class="form-control">{{ $transactions->subscription_id }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Post Id" name="post_id" type="number"
                                    :value="old('post_id', $mode == 'edit' ? $transactions->post_id : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="post_id">Post Id</label>
                                    <p class="form-control">{{ $transactions->post_id }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Stripe Transaction Id" name="stripe_transaction_id" type="text"
                                    :value="old('stripe_transaction_id', $mode == 'edit' ? $transactions->stripe_transaction_id : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="stripe_transaction_id">Stripe Transaction Id</label>
                                    <p class="form-control">{{ $transactions->stripe_transaction_id }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Invoice Id" name="invoice_id" type="text"
                                    :value="old('invoice_id', $mode == 'edit' ? $transactions->invoice_id : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="invoice_id">Invoice Id</label>
                                    <p class="form-control">{{ $transactions->invoice_id }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Stream Id" name="stream_id" type="text"
                                    :value="old('stream_id', $mode == 'edit' ? $transactions->stream_id : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="stream_id">Stream Id</label>
                                    <p class="form-control">{{ $transactions->stream_id }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Message Id" name="message_id" type="text"
                                    :value="old('message_id', $mode == 'edit' ? $transactions->message_id : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="message_id">Message Id</label>
                                    <p class="form-control">{{ $transactions->message_id }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Unlock Type" name="unlock_type" type="text"
                                    :value="old('unlock_type', $mode == 'edit' ? $transactions->unlock_type : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="unlock_type">Unlock Type</label>
                                    <p class="form-control">{{ $transactions->unlock_type }}</p>
                                </div>
                                @endif



                                @if ($mode == 'edit' || $mode == 'create')
                                <!-- <x-inputs.input-field class="col-xl-4 mb-3" label="Status" name="status" type="text"
                                    :value="old('status', $mode == 'edit' ? $transactions->status : '')" /> -->

                                <x-inputs.dropdown-field class="col-xl-4 mb-3" label="status" name="status"
                                    :options="[
                                    'approved' => 'Approved',
                                    'canceled' => 'Cancelled',
                                    'declined' => 'Declined',
                                    'initiated' => 'Initiated'
                                ]"
                                    :selected="old('status', $mode == 'edit' ? ($transactions->status ?? '') : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="status">Status</label>
                                    <p class="form-control">{{ $transactions->status }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Video Call Id" name="video_call_id" type="text"
                                    :value="old('video_call_id', $mode == 'edit' ? $transactions->video_call_id : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="video_call_id">Video Call Id</label>
                                    <p class="form-control">{{ $transactions->video_call_id }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Audio Call Id" name="audio_call_id" type="text"
                                    :value="old('audio_call_id', $mode == 'edit' ? $transactions->audio_call_id : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="audio_call_id">Audio Call Id</label>
                                    <p class="form-control">{{ $transactions->audio_call_id }}</p>
                                </div>
                                @endif


                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.dropdown-field class="col-xl-4 mb-3" label="Type" name="type"
                                    :options="[
                                        'deposite' => 'Deposite',
                                        'message-unlock' => 'Message-Unlock',
                                        'one-month-subscription' => 'One-Month-Subscription',
                                        'stream-access' => 'Stream-Access',
                                        'post-unlock' => 'Post-Unlock',
                                        'tip' => 'Tip',
                                        'withdrawal' => 'Withdrawal'
                                    ]"
                                    :selected="old('type', $mode == 'edit' ? ($transactions->type ?? '') : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="type">Type</label>
                                    <p class="form-control">{{ $transactions->type }}</p>
                                </div>
                                @endif


                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Chat Id" name="chat_id" type="text"
                                    :value="old('chat_id', $mode == 'edit' ? $transactions->chat_id : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="chat_id">Chat Id</label>
                                    <p class="form-control">{{ $transactions->chat_id }}</p>
                                </div>
                                @endif


                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Payment Provider" name="payment_provider" type="text"
                                    :value="old('payment_provider', $mode == 'edit' ? $transactions->payment_provider : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="payment_provider">Payment Provider</label>
                                    <p class="form-control">{{ $transactions->payment_provider }}</p>
                                </div>
                                @endif


                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Artist Amount" name="amount" type="number"
                                    :value="old('amount', $mode == 'edit' ? $transactions->amount : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="amount">Artist Amount</label>
                                    <p class="form-control">{{ $transactions->amount }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="nowpayments_payment_id" name="Nowpayments Payment Id" type="text"
                                    :value="old('nowpayments_payment_id', $mode == 'edit' ? $transactions->nowpayments_payment_id : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="nowpayments_payment_id">Nowpayments Payment Id</label>
                                    <p class="form-control">{{ $transactions->nowpayments_payment_id }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="nowpayments_order_id" name="Nowpayments Order Id" type="text"
                                    :value="old('nowpayments_order_id', $mode == 'edit' ? $transactions->nowpayments_order_id: '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="nowpayments_order_id">Nowpayments Order Id</label>
                                    <p class="form-control">{{ $transactions->nowpayments_order_id }}</p>
                                </div>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Created At" name="created_at" type="text"
                                    :value="old('created_at', $mode == 'edit' ? $transactions->created_at : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="created_at">Created At</label>
                                    <p class="form-control">{{ $transactions->created_at }}</p>
                                </div>
                                @endif



                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="ccbill Payment Token" name="ccbill_payment_token" type="text"
                                    :value="old('ccbill_payment_token', $mode == 'edit' ? $transactions->ccbill_payment_token : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="ccbill_payment_token">ccbil Payment Token</label>
                                    <p class="form-control">{{ $transactions->ccbill_payment_token }}</p>
                                </div>

                                @endif



                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="ccbil Transaction Id" name="ccbill_transaction_id" type="text"
                                    :value="old('ccbill_transaction_id', $mode == 'edit' ? $transactions->ccbill_transaction_id : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="ccbill_transaction_id">ccbill Transaction Id</label>
                                    <p class="form-control">{{ $transactions->ccbill_transaction_id }}</p>
                                </div>

                                @endif



                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="Updated At" name="ccbill_subscription_id" type="text"
                                    :value="old('ccbill_subscription_id', $mode == 'edit' ? $transactions->ccbill_subscription_id : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="updated_at">ccbill Subscription Id</label>
                                    <p class="form-control">{{ $transactions->ccbill_subscription_id }}</p>
                                </div>

                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                                <x-inputs.input-field class="col-xl-4 mb-3" label="paystack_payment_token" name="Paystack Payment Token" type="text"
                                    :value="old('paystack_payment_token', $mode == 'edit' ? $transactions->paystack_payment_token : '')" />
                                @else
                                <div class="col-xl-4 mb-3">
                                    <label class="form-label mt-0" for="paystack_payment_token">Paystack Payment Token</label>
                                    <p class="form-control">{{ $transactions->paystack_payment_token }}</p>
                                </div>

                                @endif



                                @if ($mode == 'edit' || $mode == 'create')
                                <center><x-buttons.simple-button class="btn btn-primary"
                                        type="submit">{{ $mode == 'edit' ? 'Update' : 'Create' }}
                                        User</x-buttons.simple-button></center>
                                @endif

                                @if ($mode == 'edit' || $mode == 'create')
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

@endsection

@section('custom-script')
<!-- INPUT MASK JS-->
<script src="{{ asset('assets/plugins/input-mask/jquery.mask.min.js') }}"></script>

<!-- FORMVALIDATION JS -->
<script src="{{ asset('assets/js/form-validation.js') }}"></script>

<!-- SHOW PASSWORD JS -->
<script src="{{ asset('../assets/js/show-password.min.js') }}"></script>

<!-- FILE UPLOADES JS -->
<script src="{{ asset('../assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ asset('../assets/plugins/fileuploads/js/file-upload.js') }}"></script>

<!-- SELECT2 JS -->
<script src="{{ asset('../assets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('../assets/js/select2.js') }}"></script>
@endsection