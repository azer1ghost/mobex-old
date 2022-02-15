@extends('branch.layout')

@section('content')
    <div class="row justify-content-center m-5">
        <div class="col-12 card">
            <div class="card-header">
                <h6>
                    Məntəqə
                </h6>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>CWB</th>
                        <th>Weight</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($packages as $package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $package->user->name }}</td>
                            <td>{{ $package->custom_id }} kg</td>
                            <td>{{ $package->weight }}</td>
                            <td>{{ $package->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="alert alert-warning text-center" role="alert">
                                   Hazırda heç bir bağlama mövcud deyil
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection