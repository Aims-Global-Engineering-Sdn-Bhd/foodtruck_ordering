<div class="container my-5">
    <div class="card shadow border-0 p-4 rounded-4">
        {{-- Order Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
            <div>
                <h3 class="text-primary mb-1 fw-bold">Order #{{ $order->order_id }}</h3>
                <p class="text-muted mb-0"><strong>Customer:</strong> {{ $order->customer_name }}</p>

                @if($order->pickup_time)
                    <p><strong>Picked Up At:</strong> {{ \Carbon\Carbon::parse($order->pickup_time)->format('d M Y, h:i A') }}</p>
                @endif
            </div>

            {{-- Dynamic Status Text --}}
            <span class="badge
                @if($order->status == 0) bg-secondary
                @elseif($order->status == 1) bg-warning
                @elseif($order->status == 2) bg-info
                @elseif($order->status == 3) bg-success
                @elseif($order->status == 4) bg-danger
                @endif
                fs-6 px-3 py-2 rounded-pill mt-3 mt-md-0">
                @switch($order->status)
                    @case(0) 📝 Order Submitted @break
                    @case(1) 🔥 Preparing Order @break
                    @case(2) 🚗 Ready to Pickup @break
                    @case(3) ✅ Completed @break
                    @case(4) Cancelled @break
                    @default Pending
                @endswitch
            </span>
        </div>

        {{-- Payment Message for Submitted Orders --}}
        @if($order->status == 0)
            <div class="alert alert-info d-flex align-items-center rounded-3 shadow-sm">
                <i class="ni ni-money-coins me-2 fs-5 text-primary"></i>
                <div>
                    <strong>Thank you for your order!</strong>
                    Please proceed to the counter for <strong>payment</strong> to confirm your order.
                </div>
            </div>
        @endif

        {{-- Progress Bar --}}
        <div class="mb-4">
            <label class="fw-bold text-dark mb-2">Order Progress</label>
            <div class="progress" style="height: 25px;">
                <div
                    class="progress-bar progress-bar-striped progress-bar-animated
                        @if($order->status == 2 || $order->status == 3) bg-success @endif
                        @if($order->status == 4) bg-danger @endif"
                    role="progressbar"
                    style="width: {{ $progress }}%;"
                >
                    {{ $progress }}%
                </div>
            </div>
        </div>

        {{-- Order Details --}}
        <div class="table-responsive">
            <h5 class="mt-4 mb-3 fw-bold text-dark">Order Details</h5>
            <table class="table align-middle table-striped mb-0">
                <thead class="table-light">
                <tr>
                    <th>Menu</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-end">Subtotal (RM)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bookings as $item)
                    <tr>
                        <td class="fw-semibold">
                            {{ $item->menu->name ?? 'Unknown' }}
                            @if(!empty($item->remark))
                                <p class="text-muted small mt-1 mb-0">
                                    <i class="ni ni-chat-round me-1 text-primary"></i>
                                    <strong>Remark:</strong> {{ $item->remark }}
                                </p>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end">{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="2" class="text-end fw-bold">Total Amount (RM):</td>
                        <td class="text-end fw-bold">{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Order Remark Section --}}
        <div class="mt-4">
            <h5 class="fw-bold text-dark mb-2">Remark</h5>

            @if(!empty($order->remarks))
                <div class="alert alert-secondary shadow-sm rounded-3">
                    <p class="mb-0 text-dark">{{ $order->remarks }}</p>
                </div>
            @else
                <div class="alert alert-light border shadow-sm rounded-3 text-muted">
                    No remarks added for this order.
                </div>
            @endif
        </div>

        {{-- Bottom Section --}}
        <div class="mt-4 text-center">
            @if($order->status == 2)
                <button wire:click="completeOrder" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                    <i class="ni ni-check-bold"></i> Mark as Picked Up
                </button>
            @elseif($order->status == 3)
                <div class="alert alert-success text-white mt-3 mb-0 rounded-pill fw-semibold">
                    ✅ Order completed and picked up!
                </div>
            @elseif($order->status ==0)
                <button id="cancelOrderBtn" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">
                   Cancel Order
                </button>
            @endif
        </div>
    </div>

    {{-- Auto-refresh every 5 seconds --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Auto-refresh
            setInterval(() => {
                Livewire.dispatch('refreshStatus');
            }, 5000);

            // SweetAlert confirmation for cancelling order
            const cancelBtn = document.getElementById('cancelOrderBtn');
            if (cancelBtn) {
                cancelBtn.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Cancel this order?',
                        text: "This action cannot be undone once confirmed.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, cancel it',
                        cancelButtonText: 'No, keep it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('cancelOrder');
                        }
                    });
                });
            }

            // Listen for order-updated event from Livewire
            Livewire.on('order-updated', (data) => {
                Swal.fire({
                    title: '✅ Success',
                    text: data.message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        });
    </script>
</div>
