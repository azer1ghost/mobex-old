<div class="row">
    <div class="col-md-6 adress_info_col">
        <span>Adres başlığı: </span>
        <p>{{ env('APP_NAME') }}</p>
        <span class="copy_text"><i class="far fa-clone"></i></span>
    </div>
    <div class="col-md-6 adress_info_col">
        <span>Ad Soyad: </span>
        <p>{{ auth()->user()->full_name }}</p>
        <span class="copy_text"><i class="far fa-clone"></i></span>
    </div>
    @if($addresses->city)
        <div class="col-md-6 adress_info_col">
            <span>İl/Şehir: </span>
            <p>{{ $addresses->city  }}</p>
            <span class="copy_text"><i class="far fa-clone"></i></span>
        </div>
    @endif
    @if($addresses->phone)
        <div class="col-md-6 adress_info_col">
            <span>Telefon: </span>
            <p>{{ $addresses->phone }}</p>
            <span class="copy_text"><i class="far fa-clone"></i></span>
        </div>
    @endif
    @if($addresses->state)
        <div class="col-md-6 adress_info_col">
            <span>İlçe: </span>
            <p>{{ $addresses->state }}</p>
            <span class="copy_text"><i class="far fa-clone"></i></span>
        </div>
    @endif

    @if($addresses->passport)
        <div class="col-md-6 adress_info_col">
            <span>TC kimlik: </span>
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
            <span>Mahalle/Semt: </span>
            <p>{{ $addresses->region }}</p>
            <span class="copy_text"><i class="far fa-clone"></i></span>
        </div>
    @endif
    <div class="col-lg-12 adress_info_col">
        <span>Adres: </span>
        <p>{{ auth()->user()->customer_id }} {{ $addresses->address_line_1 }}</p>
        <span class="copy_text"><i class="far fa-clone"></i></span>
    </div>
</div>