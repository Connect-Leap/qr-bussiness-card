@if (request()->get('card_theme') == 'light')
    <div class="border border-2 rounded">
        <div class="container my-3">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('img/card-asset/icon-logo.png') }}" class="img-fluid" alt="">
                        <span class="mt-1 fw-bold" style="font-family: 'Baskervville', serif;">ABC Corporation</span>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-12">
                    <p class="fw-bold" style="font-family: 'Baskervville', serif; font-size: 30pt; line-height: 30px">
                        David Jameson Green <br><span style="font-size: 15pt">Assistant Manager Tax</span></p>
                </div>

            </div>
            <div class="border border-2 fw-bold"></div>
            <div class="row mt-2">
                <div class="col-10">
                    <p class="fw-bold" style="font-family: 'Baskervville', serif; font-size: 12pt; line-height: 30px">
                        ABC Corporation <br> Jl.Raya Kebayoran Lama No.12, Jakarta Selatan <br> (021) 812-356-789</p>
                </div>
                <div class="col-2">
                    <img src="{{ asset('img/card-asset/qrcode.png') }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
@elseif(request()->get('card_theme') == 'dark')
    <div class="border border-2 rounded bg-dark">
        <div class="container my-3">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('img/card-asset/icon-logo.png') }}" class="img-fluid" alt="">
                        <span class="mt-1 fw-bold text-white" style="font-family: 'Baskervville', serif;">ABC Corporation</span>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-12">
                    <p class="fw-bold text-white" style="font-family: 'Baskervville', serif; font-size: 30pt; line-height: 30px">
                        David Jameson Green <br><span style="font-size: 15pt">Assistant Manager Tax</span></p>
                </div>

            </div>
            <div class="border border-2 fw-bold"></div>
            <div class="row mt-2">
                <div class="col-10">
                    <p class="fw-bold text-white" style="font-family: 'Baskervville', serif; font-size: 12pt; line-height: 30px">
                        ABC Corporation <br> Jl.Raya Kebayoran Lama No.12, Jakarta Selatan <br> (021) 812-356-789</p>
                </div>
                <div class="col-2">
                    <img src="{{ asset('img/card-asset/qrcode.png') }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
@else
    <div class="border border-2 rounded">
        <div class="container my-3">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('img/card-asset/icon-logo.png') }}" class="img-fluid" alt="">
                        <span class="mt-1 fw-bold" style="font-family: 'Baskervville', serif;">ABC Corporation</span>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-12">
                    <p class="fw-bold" style="font-family: 'Baskervville', serif; font-size: 30pt; line-height: 30px">
                        David Jameson Green <br><span style="font-size: 15pt">Assistant Manager Tax</span></p>
                </div>

            </div>
            <div class="border border-2 fw-bold"></div>
            <div class="row mt-2">
                <div class="col-10">
                    <p class="fw-bold" style="font-family: 'Baskervville', serif; font-size: 12pt; line-height: 30px">
                        ABC Corporation <br> Jl.Raya Kebayoran Lama No.12, Jakarta Selatan <br> (021) 812-356-789</p>
                </div>
                <div class="col-2">
                    <img src="{{ asset('img/card-asset/qrcode.png') }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
@endif
