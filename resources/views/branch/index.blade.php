@extends('branch.layout')

@section('content')
    <div class="row justify-content-center ">
        @include('branch.widgets', $widgets)
        <div class="col-12 card mt-2 p-5">
            <div class="card-header">
                @include('branch.filters', $filters)
            </div>
            <div class="card-body">
                <table class="table text-center" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Müştəri Kodu</th>
                            <th>Müştəri</th>
                            <th>Bağlama Kodu</th>
                            <th>Məbləği</th>
                            <th >Ödəniş</th>
                            <th>Cəkisi</th>
                            <th>Statusu</th>
                            <th>Çatıb</th>
                            <th>Əməliyyat</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($packages as $package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="width: 140px"><b>{{ $package->user->customer_id }}</b></td>
                            <td>{{ $package->user->full_name }} </td>
                            <td>{{ $package->custom_id }}</td>
                            <td>{{ $package->shippingOrgPrice }}</td>
                            <td><i class="fa {{ $package->paid ? 'text-success fa-check' : 'text-danger fa-times'}}"></i></td>
                            <td>{{ $package->weight }} kg</td>
                            <td>{{ config('ase.attributes.package.status_az')[$package->status] }}</td>
                            <td>{{ optional($package->branch_arrived_at)->diffForHumans() }}</td>
                            <td>
                                @if($package->paid)
                                    <a class="btn btn-sm btn-outline-success">
                                        Təhvil ver
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="alert alert-warning text-center" role="alert">
                                   Hazırda heç bir bağlama mövcud deyil
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{$packages->links('vendor.pagination.bootstrap-4')}}
            </div>
        </div>
    </div>
@endsection