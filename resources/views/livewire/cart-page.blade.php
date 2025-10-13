<div class="container mt-4 mb-5">

    <h3 class="mb-4 text-primary fw-bold">Your Cart</h3>

    @if(empty($cart))
        {{-- Empty Cart --}}
        <div class="text-center py-5">
            <p class="h5 text-muted mb-3">Your cart is empty.</p>
            <a href="{{ route('menu.list') }}" class="btn btn-primary shadow-sm">
                <i class="ni ni-bold-left me-2"></i> Back to Menu
            </a>
        </div>

    @else
        <div class="row g-3">

            {{-- Cart Items --}}
            @foreach($cart as $menuId => $item)
                <div class="col-12">
                    <div class="card border-0 shadow-sm p-3 d-flex flex-column flex-md-row align-items-center">

                        {{-- Item Details --}}
                        <div class="flex-grow-1 text-center text-md-start">
                            <h6 class="fw-bold text-dark mb-1">{{ $item['name'] }}</h6>
                            <p class="text-muted small mb-2">RM {{ number_format($item['price'], 2) }} / unit</p>

                            {{-- Quantity Controls --}}
                            <div class="d-flex justify-content-center justify-content-md-start align-items-center gap-2">
                                <button wire:click="decrement('{{ $menuId }}')"
                                        class="btn btn-primary rounded-circle p-2 shadow-sm d-flex align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                         stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus">
                                        <path d="M5 12h14"/>
                                    </svg>
                                </button>

                                <span class="fw-bold px-2">{{ $item['quantity'] }}</span>

                                <button wire:click="increment('{{ $menuId }}')"
                                        class="btn btn-primary rounded-circle p-2 shadow-sm d-flex align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                         stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                                        <path d="M5 12h14"/>
                                        <path d="M12 5v14"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Subtotal & Remove --}}
                        <div class="text-center text-md-end mt-3 mt-md-0 ms-md-3">
                            <p class="fw-bold text-dark mb-1">
                                RM {{ number_format($item['price'] * $item['quantity'], 2) }}
                            </p>
                            <button wire:click="remove('{{ $menuId }}')"
                                    class="btn btn-sm btn-danger rounded-pill shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="15"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                     stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                                    <path d="M18 6 6 18"/>
                                    <path d="m6 6 12 12"/>
                                </svg>
                                Remove
                            </button>
                        </div>

                    </div>
                </div>
            @endforeach

            {{-- Total Section --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm p-3 bg-light d-flex flex-md-row flex-column justify-content-between align-items-center">
                    <h5 class="fw-bold mb-2 mb-md-0 text-dark">Total</h5>
                    <h5 class="fw-bold text-primary mb-0">
                        RM {{ number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']), 2) }}
                    </h5>
                </div>
            </div>

            {{-- Customer Info --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm p-4">

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Your Name</label>
                        <input type="text" wire:model="customerName"
                               class="form-control shadow-sm" placeholder="Enter your name" required>
                        @error('customerName') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Remarks (optional)</label>
                        <input type="text" wire:model="remark"
                               class="form-control shadow-sm" placeholder="Any special requests?">
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="text-end mt-4">
                    <button wire:click="placeOrder"
                            wire:loading.attr="disabled"
                            class="btn btn-primary px-5 py-2 shadow-sm">
                        <span wire:loading.remove>
                            <i class="ni ni-check-bold me-2"></i> Place Order
                        </span>
                        <span wire:loading>
                            <i class="spinner-border spinner-border-sm me-2"></i> Processing...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
