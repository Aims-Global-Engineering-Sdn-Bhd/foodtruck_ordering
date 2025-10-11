@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'New Menu')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'New Menu'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-10 col-md-12 mx-auto">
                <div class="card mb-4 shadow-sm">
                    {{-- Header --}}
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Add New Menu</h6>
                        <a href="{{ route('menu.index') }}" class="btn btn-sm btn-light border">
                            <i class="ni ni-bold-left"></i> Back
                        </a>
                    </div>

                    {{-- Body --}}
                    <div class="card-body px-4 pt-4 pb-3">

                        {{-- Success alert --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Validation errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- 🟩 Section 1: Basic Information --}}
                            <h6 class="text-primary mb-3"><i class="ni ni-folder-17"></i> Basic Information</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Menu Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Nasi Goreng Ayam" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Price (RM) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" id="price" class="form-control" step="0.01" placeholder="0.00" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="category" id="category" class="form-select" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat }}" {{ isset($selected) && $selected == $cat ? 'selected' : '' }}>
                                                {{ $cat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="avail_status" class="form-label">Availability <span class="text-danger">*</span></label>
                                    <select name="avail_status" id="avail_status" class="form-select" required>
                                        <option value="1">Available</option>
                                        <option value="0">Unavailable</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- 🟦 Section 2: Description & Details --}}
                            <h6 class="text-primary mb-3"><i class="ni ni-single-copy-04"></i> Description & Details</h6>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3" placeholder="Describe the menu item, ingredients, or taste..."></textarea>
                            </div>

                            <hr class="my-4">

                            {{-- 🟧 Section 3: Image Upload --}}
                            <h6 class="text-primary mb-3"><i class="ni ni-image"></i> Menu Image</h6>
                            <div class="mb-4">
                                <label for="url_food" class="form-label">Upload Image</label>
                                <input type="file" name="url_food" id="url_food" class="form-control" accept="image/*">
                                <small class="text-muted">Accepted formats: JPG, JPEG, PNG, GIF (Max: 4MB)</small>
                            </div>

                            <hr class="my-4">

                            {{-- 🟨 Section 4: Additional Information --}}
                            <h6 class="text-primary mb-3"><i class="ni ni-collection"></i> Additional Information</h6>
                            <div class="mb-4">
                                <label for="remark" class="form-label">Remark</label>
                                <textarea name="remark" id="remark" class="form-control" rows="2" placeholder="Any extra notes (e.g., seasonal availability, special prep)"></textarea>
                            </div>

                            {{-- Submit Button --}}
                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('menu.index') }}" class="btn btn-light me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ni ni-check-bold"></i> Save Menu
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth.footer')
    </div>
@endsection
