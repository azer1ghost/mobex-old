@extends(config('saysay.crud.layout'))

@section('content')
    <style>
        .declared {
            background-color: #4caf50;
            padding: 5px;
            border-radius: 8px;
            color: #fff;
        }
        th, td {
            font-size: 22px !important;
            padding: 2px 18px;
        }
    </style>
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div style="margin-top: 30px">
                <table style="margin: 0 auto;" class="chess-board">
                    <tbody>
                    <tr>
                        <th></th>
                        <?php $max = 0; ?>
                        @foreach (cellStructureForWarehouse() as $let => $value)
                            <?php $max = $value > $max ? $value : $max; ?>
                            <th>{{ $let }}</th>
                        @endforeach
                    </tr>
                    @for($i = 1; $i <= $max; $i++)
                        <tr>
                            <th>{{ $i }}</th>
                            @foreach (cellStructureForWarehouse() as $let => $value)
                                @if($i <= $value)
                                    <?php $cellName = $let . $i; $numPack = isset($cells[$cellName]) ? $cells[$cellName] : 0; ?>
                                    <?php $numPackDeclared = isset($declaredCells[$cellName]) ? $declaredCells[$cellName] : 0; ?>
                                    <?php $weight = isset($weights[$cellName]) ? $weights[$cellName] : 0; ?>
                                    <?php $percent = $numPack ? (50 - (50 * $numPackDeclared / $numPack)) : 0; ?>
                                    <td data-id="{{ $cellName }}" class="light select_cell"
                                        style="background: {{ luminance($percent) }}">
                                        <div class="@if((isset($item->warehouse_cell) && $item->warehouse_cell == $cellName )) pulse @endif">{{ $numPack }} @if($numPackDeclared)
                                                / <a href="{{ route('w-packages.index') }}?custom_status=1&cell={{ $cellName }}" class="declared">{{ $numPackDeclared }}</a> @endif / {{ $weight }}kq </div>
                                    </td>
                                @else
                                    <td style="border: none !important;"></td>
                                @endif
                            @endforeach

                        </tr>
                    @endfor

                    </tbody>
                </table>

                <div class="panel panel-flat" style="padding: 20px; margin-top: 20px">
                    {!! Form::open(['method' => 'get','route' =>'warehouse.cells']) !!}
                    <div class="row">
                        <div class="col-md-10">
                            <label>Type package tracking code ?? cwb number</label>
                            <input placeholder="{{ env('MEMBER_PREFIX_CODE') }}0000000" type="text" name="cwb" value="{{ request()->get('cwb') }}"
                                   class="form-control">

                        </div>
                        <div class="col-md-2">
                            <button style="margin-top: 20px;" type="submit"
                                    class="btn btn-info legitRipple">Find
                            </button>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection