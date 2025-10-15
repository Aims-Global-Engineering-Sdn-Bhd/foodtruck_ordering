<div wire:poll.10s="refreshMenus">
    {{-- Restaurant Banner --}}
    {{--<div class="card border-0 shadow-sm mb-4">
        <img src="{{ asset('img/backgroundtkcafe.jpg') }}" class="card-img-top rounded-3" alt="Restaurant Banner">
    </div>--}}

    {{-- Category Filter Buttons --}}
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
        <button wire:click="filterCategory(null)"
                class="btn btn-sm px-3 {{ $selectedCategory === null ? 'btn-primary' : 'btn-outline-primary' }}">
            All
        </button>

        @foreach($categories as $category)
            <button wire:click="filterCategory('{{ $category }}')"
                    class="btn btn-sm px-3 {{ $selectedCategory === $category ? 'btn-primary' : 'btn-outline-primary' }}">
                {{ strtoupper($category) }}
            </button>
        @endforeach
    </div>

    {{-- Menu List --}}
    @foreach($groupedMenus as $category => $items)
        <div class="mb-5">
            <div class="card border-0 shadow-sm mb-3 bg-light">
                <div class="card-body py-2">
                    <h5 class="fw-bold text-primary mb-0">{{ strtoupper($category) }}</h5>
                </div>
            </div>

            <div class="row g-3">
                @foreach($items as $menu)
                    <div class="col-md-4 col-sm-6">
                        <div class="card shadow-sm border-0 h-100 {{ $menu->avail_status ? '' : 'opacity-50 position-relative' }}">

                            {{-- Unavailable overlay --}}
                            @if(!$menu->avail_status)
                                <div class="position-absolute top-50 start-50 translate-middle bg-danger bg-opacity-75 text-white px-3 py-1 rounded">
                                    <span>Out Of Stock</span>
                                </div>
                            @endif

                            {{-- Menu Image --}}
                            @if($menu->url_food)
                                <img src="{{ asset($menu->url_food) }}"
                                     alt="{{ $menu->name }}"
                                     class="card-img rounded-top"
                                     style="max-height: 250px; object-fit: cover; width: 100%;">
                            @else
                                <div class="border rounded-3 shadow-sm d-inline-block p-5 bg-light text-muted text-center">
                                    <i class="ni ni-image text-secondary" style="font-size: 2rem;"></i>
                                    <p class="mt-2 mb-0">No image available</p>
                                </div>
                            @endif

                            {{-- Menu Details --}}
                            <div class="card-body d-flex flex-column">
                                <h6 class="fw-bold">{{ $menu->name }}</h6>
                                <p class="text-muted small mb-2">{{ $menu->description }}</p>

                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">RM {{ number_format($menu->price, 2) }}</span>

                                    <button wire:click="addToCart({{ $menu->id }})"
                                            class="btn btn-sm btn-primary"
                                            @if(!$menu->avail_status) disabled @endif>
                                        <i class="ni ni-fat-add"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- Floating Cart Button --}}
    <a href="{{ route('guest.cart') }}"
       class="btn btn-primary position-fixed rounded-circle shadow-lg"
       style="bottom: 20px; right: 20px; width: 60px; height: 60px;">
        <i class="ni ni-cart text-white fs-4"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $cartCount }}
        </span>
    </a>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:load', () => {
            Livewire.on('cart-added', event => {
                alert(event.message);
            });
        });
    </script>
@endpush
