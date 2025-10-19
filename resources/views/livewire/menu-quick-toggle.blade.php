 <div class="container-fluid py-4">
    @foreach ($menusByCategory as $category => $menus)
        <div class="accordion mb-4" id="accordion-{{ Str::slug($category) }}">
            <div class="accordion-item bg-white border-0 shadow-sm rounded-3">

                {{-- Accordion Header --}}
                <h2 class="accordion-header" id="heading-{{ Str::slug($category) }}">
                    <button
                        class="accordion-button text-dark fw-bold bg-light"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse-{{ Str::slug($category) }}"
                        aria-expanded="true"
                    >
                        <i class="ni ni-bullet-list-67 text-primary me-2"></i>
                        {{ ucfirst($category) }}
                    </button>
                </h2>

                {{-- Accordion Body --}}
                <div id="collapse-{{ Str::slug($category) }}" class="accordion-collapse collapse show">
                    <div class="accordion-body bg-light rounded-bottom">
                        <div class="row g-3">
                            @foreach ($menus as $menu)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="card shadow-sm border-0 h-100">
                                        <div class="position-relative">
                                            <img
                                                src="{{ asset($menu['url_food']) }}"
                                                class="card-img-top"
                                                style="height: 130px; object-fit: cover; border-top-left-radius: .5rem; border-top-right-radius: .5rem;"
                                            >

                                            {{-- Red overlay for unavailable --}}
                                            @if(!$menu['avail_status'])
                                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-danger bg-opacity-50 rounded-top">
                                                    <span class="text-white fw-bold fs-6" style="transform: rotate(-20deg);">
                                                        UNAVAILABLE
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="card-body text-center p-3">
                                            <h6 class="card-title text-truncate mb-3">{{ $menu['name'] }}</h6>
                                            <button
                                                wire:click="toggleStatus({{ $menu['id'] }})"
                                                class="btn btn-sm {{ $menu['avail_status'] ? 'btn-success' : 'btn-danger' }} w-100"
                                            >
                                                {{ $menu['avail_status'] ? 'Available' : 'Unavailable' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endforeach
</div>
