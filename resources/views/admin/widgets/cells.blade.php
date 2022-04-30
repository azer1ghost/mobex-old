@if(app('laratrust')->can('update-cells'))
    <?php

    $cells = App\Models\Package::select([
        \DB::raw('count(id) as total'),
        'cell',
    ])->whereNotNull('cell')->where('status', 2)->groupBy('cell')->orderBy('cell', 'asc');

    /* Filter filials */
    $filials = auth()->guard('admin')->user()->filials ? auth()->guard('admin')->user()->filials->pluck('id')->all() : null;
    if ($filials) {
        $cells->whereHas('user', function (
            $query
        ) use ($filials) {
            $query->whereIn('filial_id', $filials)->orWhere('filial_id', null);
        });
    }


    $cells = $cells->pluck('total', 'cell')->all();

    ?>
    @if(request()->filled('sent_to_post'))
        <div class="mt-5 col-6 alert alert-success">
            <h3>Diqqət!!! Bağlama Azerpocta göndərilməlidir</h3>
        </div>
    @endif
    <div style="margin-top: 30px">
        <table style="margin: 0 auto;" class="chess-board">
            <tbody>
            <tr>
                <th></th>
                <?php $max = 0; ?>
                @foreach (cellStructure() as $let => $value)
                    <?php $max = $value > $max ? $value : $max; ?>
                    <th>{{ $let }}</th>
                @endforeach
            </tr>
            @for($i = 1; $i <= $max; $i++)
                <tr>
                    <th>{{ $i }}</th>
                    @foreach (cellStructure() as $let => $value)
                        @if($i <= $value)
                            <?php $cellName = $let . $i; $numPack = isset($cells[$cellName]) ? $cells[$cellName] : 0; ?>
                            <td data-id="{{ $cellName }}" class="light select_cell"
                                style="background: {{ luminance($numPack) }}">
                                <div class="@if((isset($nearBy) && $nearBy == $cellName) || (isset($item->cell) && $item->cell ==$cellName )) pulse @endif">{{ $numPack }}</div>
                            </td>
                        @else
                            <td style="border: none !important;"></td>
                        @endif
                    @endforeach

                </tr>
            @endfor

            </tbody>
        </table>
    </div>
@endif