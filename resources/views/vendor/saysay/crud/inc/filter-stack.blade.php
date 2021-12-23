@if(isset($_view['search']))
    @if (isset($_view['checklist']) && $_can['export'])
        {!! Form::open(['id' => 'export_form', 'method' => 'get', 'route' => $crud['route'] . ".export"]) !!}
        {!! Form::hidden('hidden_items') !!}
        {!! Form::close() !!}
    @endif
    {!! Form::open(['method' => 'get', 'class' => 'mr-15 mb-20', 'id' => 'search_form']) !!}
    {!! Form::hidden('search_type') !!}
    {!! Form::hidden('sort', 'created_at__desc') !!}

    <div class="row">
        <div class="col-lg-9">
            <div class="row">

                @foreach($_view['search'] as $_filter)
                    @include('crud::fields.' . $_filter['type'], ['field' => $_filter])
                @endforeach
            </div>
        </div>
        <div class="col-lg-3">
            <div class="row">
                <div class="col-lg-5">
                    @include('crud::fields.select_from_array', ['field' =>  [
                        'name'              => 'limit',
                        'type'              => 'select_from_array',
                        'optionsFromConfig' => 'ase.attributes.pagination']])
                </div>
                <div class="col-lg-7">
                    <div class="btn-group">
                        <a href="?" class="btn btn-warning btn-icon"><i class="icon-close2"></i></a>
                        <button name="search" class="btn btn-primary btn-icon"><i class="icon-search4"></i></button>
                        @if($_can['export'])
                            <button type="submit" id="export" name="export" class="btn btn-success btn-icon"><i
                                        class="icon-file-download"></i></button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endif