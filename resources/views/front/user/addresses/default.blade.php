@if($warehouse->addresses->count() > 1)
    <h3 class="mb-3">{{ $addresses->title }}</h3>
@endif
<div class="row" style="margin-bottom: 20px;border-bottom: 1px solid #ccc;padding-bottom: 20px;">
    <div class="col-md-6 adress_info_col">
        <span>Address title: </span>
        <p>{{ env('APP_NAME') }}</p>
        <span class="copy_text"><i class="far fa-clone"></i></span>
    </div>
    <div class="col-md-6 adress_info_col">
        <span>Full name: </span>
        <p>{{ $addresses->contact_name or auth()->user()->full_name }}</p>
        <span class="copy_text"><i class="far fa-clone"></i></span>
    </div>
    @if($addresses->state)
        <div class="col-md-6 adress_info_col">
            <span>Country: </span>
            <p>{{ $addresses->state }}</p>
            <span class="copy_text"><i class="far fa-clone"></i></span>
        </div>
    @endif

    @if($addresses->phone)
        <div class="col-md-6 adress_info_col">
            <span>Phone: </span>
            <p>{{ $addresses->phone }}</p>
            <span class="copy_text"><i class="far fa-clone"></i></span>
        </div>
    @endif
    @if($addresses->city)
        <div class="col-md-6 adress_info_col">
            <span>City: </span>
            <p>{{ $addresses->city  }}</p>
            <span class="copy_text"><i class="far fa-clone"></i></span>
        </div>
    @endif
    @if($addresses->passport)
        <div class="col-md-6 adress_info_col">
            <span>Passport: </span>
            <p>{{ $addresses->passport }}</p>
            <span class="copy_text"><i class="far fa-clone"></i></span>
        </div>
    @endif
    @if($addresses->zip_code)

        <div class="col-md-6 adress_info_col">
            <span>ZIP: </span>
            <p>{{ $addresses->zip_code }}</p>
            <span class="copy_text"><i class="far fa-clone"></i></span>
        </div>
    @endif
    @if($addresses->region)
        <div class="col-md-6 adress_info_col">
            <span>Region: </span>
            <p>{{ $addresses->region }}</p>
            <span class="copy_text"><i class="far fa-clone"></i></span>
        </div>
    @endif
    @if($addresses->address_line_1)
        <div class="col-lg-12 adress_info_col">
            <span>Address: </span>
            <p>{{ str_replace(":code", auth()->user()->customer_id . " ", $addresses->address_line_1) }}</p>
            <span class="copy_text"><i class="far fa-clone"></i></span>
        </div>
    @endif

    @if($addresses->address_line_2)
        <div class="col-lg-12 adress_info_col">
            <span>Address #2: </span>
            <p>{{ str_replace(":code", auth()->user()->customer_id . " ", $addresses->address_line_2) }}</p>
            <span class="copy_text"><i class="far fa-clone"></i></span>
        </div>
    @endif
</div>