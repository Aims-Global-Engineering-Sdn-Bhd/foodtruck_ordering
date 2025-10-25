<div class="container">
    <div class="alert alert-info text-center fw-bold mb-3 rounded">
        ⚠️ Keep this page active to receive new order sound notifications!
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-transparent border-0">
        </div>

        <div class="card-body pt-0">
            <div class="row">
                {{-- 🆕 NEW ORDERS --}}
                <div class="col-md-6 border-end border-3 border-secondary">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="text-danger fw-bold mb-0">
                            🆕 New Orders
                        </h5>
                        <span class="badge bg-gradient-danger ms-2">{{ count($newOrders) }}</span>
                    </div>

                    @forelse($newOrders as $order)
                        <div class="card card-frame mb-3 border-0 shadow-sm bg-gradient-light">
                            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <h6 class="fw-bold mb-1">Order #{{ $order->order_id }}</h6>
                                    <p class="mb-1 text-sm text-muted">
                                        <i class="ni ni-single-02"></i> {{ $order->customer_name }}
                                    </p>
                                    <span class="badge bg-gradient-danger">Pending Payment</span>
                                    <p class="text-xs text-muted mb-0 mt-1">
                                        <i class="ni ni-time-alarm"></i> {{ $order->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <div class="mt-4 mt-md-0">
                                    <button class="btn btn-sm btn-outline-primary me-2"
                                            wire:click="$dispatch('loadOrderDetail', { orderId: {{ $order->id }} })"
                                            data-bs-toggle="modal"
                                            data-bs-target="#orderDetailModal">
                                        <i class="ni ni-zoom-split-in"></i> View
                                    </button>

                                    <button class="btn btn-sm btn-success me-2"
                                            wire:click="completePayment({{ $order->id }})">
                                        <i class="ni ni-check-bold"></i> Payment Done
                                    </button>

                                    <button class="btn btn-sm btn-danger"
                                            wire:click="$dispatch('confirmCancelOrder', { orderId: {{ $order->id }} })">
                                        <i class="ni ni-fat-remove"></i> Cancel
                                    </button>

                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-sm fst-italic">No new orders available.</p>
                    @endforelse
                </div>

                {{-- ⚙️ IN PROGRESS ORDERS --}}
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="text-warning fw-bold mb-0">
                            ⚙️ In Progress Orders
                        </h5>
                        <span class="badge bg-gradient-warning ms-2">{{ count($inProgressOrders) }}</span>
                    </div>

                    @forelse($inProgressOrders as $order)
                        <div class="card card-frame mb-3 border-0 shadow-sm">
                            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <h6 class="fw-bold mb-1">Order #{{ $order->id }}</h6>
                                    <p class="mb-1 text-sm text-muted">
                                        <i class="ni ni-single-02"></i> {{ $order->customer_name }}
                                    </p>
                                    <span class="badge bg-gradient-warning text-dark">In Progress</span>
                                    <p class="text-xs text-muted mb-0 mt-1">
                                        <i class="ni ni-time-alarm"></i> {{ $order->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <div class="mt-3 mt-md-0">
                                    <button class="btn btn-sm btn-outline-primary me-2"
                                            wire:click="$dispatch('loadOrderDetail', { orderId: {{ $order->id }} })"
                                            data-bs-toggle="modal"
                                            data-bs-target="#orderDetailModal">
                                        <i class="ni ni-zoom-split-in"></i> View
                                    </button>

                                    <button class="btn btn-sm btn-success"
                                            wire:click="markAsReady({{ $order->id }})">
                                        <i class="ni ni-check-bold"></i> Ready to Pickup
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-sm fst-italic">No in-progress orders right now.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    @livewire('order-detail-modal')
</div>

{{-- SweetAlert + Auto Refresh --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("livewire:init", () => {
        Livewire.on('swal:success', (data) => {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.text,
                timer: 2000,
                showConfirmButton: false,
            });
        });

        Livewire.on('new-order', () => {
            Swal.fire({
                toast: true,
                icon: 'info',
                title: '🆕 New Order Received!',
                position: 'top-end',
                timer: 3000,
                showConfirmButton: false,
                timerProgressBar: true,
            });

            const audio = new Audio('/sounds/new-order.mp3');
            audio.play();
        });

        Livewire.on('confirmCancelOrder', (data) => {
            Swal.fire({
                title: 'Cancel this order?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('cancelOrder', { orderId: data.orderId });
                }
            });
        });

    });

    // 🧠 Poll every 10 seconds for new orders
    let tabActive = true;
    document.addEventListener('visibilitychange', () => {
        tabActive = !document.hidden;
    });

    setInterval(() => {
        if (tabActive) {
            Livewire.dispatch('orderUpdated');
        }
    }, 10000);
</script>
