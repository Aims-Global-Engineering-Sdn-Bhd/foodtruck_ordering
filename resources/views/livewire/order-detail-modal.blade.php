<div wire:ignore.self class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow border-0">
            @if($order)
                {{-- Header --}}
                <div class="modal-header border-0 bg-gradient-light">
                    <h5 class="modal-title fw-bold text-primary mb-0">
                        <i class="ni ni-cart text-primary me-2"></i>
                        Order #{{ $order->id }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong><i class="ni ni-single-02 text-primary"></i> Customer:</strong></p>
                            <p class="text-sm text-muted mb-0">{{ $order->customer_name }}</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1"><strong><i class="ni ni-time-alarm text-primary"></i> Created:</strong></p>
                            <p class="text-sm text-muted mb-0">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1"><strong><i class="ni ni-tag text-primary"></i> Status:</strong></p>
                            @if($order->status == 0)
                                <span class="badge bg-gradient-danger">Pending Payment</span>
                            @elseif($order->status == 1)
                                <span class="badge bg-gradient-warning text-dark">In Progress</span>
                            @else
                                <span class="badge bg-gradient-success">Ready</span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    {{-- Order Items --}}
                    <h6 class="fw-bold mb-3">
                        <i class="ni ni-bag-17 text-primary me-2"></i> Order Items
                    </h6>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="bg-light">
                            <tr class="text-secondary text-uppercase text-xs">
                                <th>Menu</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Price (RM)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $total = 0; @endphp
                            @foreach($items as $item)
                                @php $total += $item['price'] * $item['quantity']; @endphp
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $item['menu_name'] }}
                                        @if(!empty($item['remark']))
                                            <p class="text-muted small mt-1 mb-0">
                                                <i class="ni ni-chat-round me-1 text-primary"></i>
                                                <strong>Remark:</strong> {{ $item['remark'] }}
                                            </p>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item['quantity'] }}</td>
                                    <td class="text-end">{{ number_format($item['price'], 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                            <tr>
                                <th colspan="2" class="text-end">Total Amount</th>
                                <th class="text-end text-dark fw-bold">RM {{ number_format($total, 2) }}</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Footer (optional actions later) --}}
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            @else
                {{-- Loading State --}}
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status"></div>
                    <h6 class="fw-semibold text-primary">Loading order details...</h6>
                    <p class="text-muted small mb-0">Please wait while we fetch the latest information.</p>
                </div>
            @endif
        </div>
    </div>
</div>
