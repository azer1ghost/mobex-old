@extends(config('saysay.crud.layout'))

@section('content')
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 col-md-12 col-xs-12">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6>
                        Package #{{ $id }}'s logs
                    </h6>
                </div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Data</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($logs->count())
                        @foreach($logs as $log)
                            <tr>
                                <td>
                                    @if($log->admin) <b>Admin</b> : {{ $log->admin->name }} <br/> @endif
                                    @if($log->worker) <b>Worker</b> : {{ $log->worker->name }} <br/> @endif
                                        <b>Date</b> : {{ $log->created_at }} <br/>
                                        @if($log->ip)
                                        <b>IP</b> : <a target="_blank" href="https://whatismyipaddress.com/ip/{{ $log->ip }}">{{ $log->ip }}</a> <br/>
                                        @endif
                                        <b>OS</b> : {{ getOS($log->user_agent) }} <br/>
                                        <b>Browser</b> : {{ getBrowser($log->user_agent) }} <br/>
                                </td>
                                <td>{!! $log->data !!}</td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="4">
                                    @include('crud::components.alert')
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                <div class="panel-footer">
                </div>
            </div>
        </div>
    </div>
@endsection