@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Menu Management')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Menu List'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Menu List</h6>

                        <a href="{{ route('menu.create') }}" class="btn btn-sm btn-primary">
                            <i class="ni ni-fat-add"></i>
                            Add New Menu
                        </a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text"><strong>Success!</strong> {{session('success')}}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="table-responsive p-0 ">
                            <table class="table align-items-center mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Price (RM)</th>
                                        <th>Available Status</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menus as $menu)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{$menu->name}}</td>
                                        <td class="align-middle">{{number_format($menu->price, 2)}}</td>
                                        <td class="align-middle">
                                            @if($menu->avail_status)
                                                <span class="text-success">Available</span>
                                            @else
                                                <span class="text-danger">Unavailable</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">{{$menu->category}}</td>
                                        <td class="align-middle text-center">
                                                <a href="{{ route('menu.show', $menu) }}"
                                                   class="btn btn-sm btn-info text-white"
                                                   title="View">
                                                    <i class="ni ni-single-copy-04"></i>
                                                </a>

                                                {{-- Edit button --}}
                                                <a href="{{ route('menu.edit', $menu) }}"
                                                   class="btn btn-sm btn-warning text-white"
                                                   title="Edit">
                                                    <i class="ni ni-ruler-pencil"></i>
                                                </a>

                                                {{-- Delete button --}}
                                                <form action="{{ route('menu.destroy', $menu->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this menu?')"
                                                      style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger text-white" title="Delete">
                                                        <i class="ni ni-fat-remove"></i>
                                                    </button>
                                                </form>
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
    </div>
    @include('layouts.footers.auth.footer')
    </div>
@endsection
