@if (request()->get('card_theme') == 'light')
    <div class="border border-2 rounded">
        <div class="container my-3">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('img/card-asset/icon-logo.png') }}" class="img-fluid" alt="">
                        <span class="mt-1 fw-bold"
                            style="font-family: 'Baskervville', serif;">{{ $user->office->name }}</span>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-12">
                    <p class="fw-bold" style="font-family: 'Baskervville', serif; font-size: 30pt; line-height: 30px">
                        {{ $user->employee->name }} <br><span style="font-size: 15pt">{{ $user->position->name }}</span>
                    </p>
                </div>

            </div>
            <div class="border border-2 fw-bold"></div>
            <div class="row mt-2">
                <div class="col-10">
                    <p class="fw-bold" style="font-family: 'Baskervville', serif; font-size: 12pt; line-height: 30px">
                        {{ $user->office->name }} <br> {{ $user->office->address }} <br> {{ $user->office->contact }}
                    </p>
                </div>
                <div class="col-2">
                    @if (!is_null($qr['qrcode']['redirect_link']))
                        {!! QrCode::backgroundColor(255, 255, 255, 0)->size(80)->generate(
                                route('master-qr.qr-processing', [
                                    'urlkey' => $qr['short_url']['url_key'],
                                    'qr_id' => $qr['qrcode']['id'],
                                ]),
                            ) !!}
                    @else
                        {!! QrCode::backgroundColor(255, 255, 255, 0)->size(80)->generate(
                                route('master-qr.qr-vcard-processing', [
                                    'qr_id' => $qr['qrcode']['id'],
                                ]),
                            ) !!}
                    @endif
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
                        <img src="{{ asset('img/card-asset/icon-logo-white.png') }}" class="img-fluid" alt="">
                        <span class="mt-1 fw-bold text-white"
                            style="font-family: 'Baskervville', serif;">{{ $user->office->name }}</span>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-12">
                    <p class="fw-bold text-white"
                        style="font-family: 'Baskervville', serif; font-size: 30pt; line-height: 30px">
                        {{ $user->employee->name }} <br><span
                            style="font-size: 15pt">{{ $user->position->name }}</span></p>
                </div>

            </div>
            <div class="border border-2 fw-bold"></div>
            <div class="row mt-2">
                <div class="col-10">
                    <p class="fw-bold text-white"
                        style="font-family: 'Baskervville', serif; font-size: 12pt; line-height: 30px">
                        {{ $user->office->name }} <br> {{ $user->office->address }} <br> {{ $user->office->contact }}
                    </p>
                </div>
                <div class="col-2">
                    @if (!is_null($qr['qrcode']['redirect_link']))
                        {!! QrCode::backgroundColor(255, 255, 255, 0)->color(255, 255, 255)->size(80)->generate(
                                route('master-qr.qr-processing', [
                                    'urlkey' => $qr['short_url']['url_key'],
                                    'qr_id' => $qr['qrcode']['id'],
                                ]),
                            ) !!}
                    @else
                        {!! QrCode::backgroundColor(255, 255, 255, 0)->color(255, 255, 255)->size(80)->generate(
                                route('master-qr.qr-vcard-processing', [
                                    'qr_id' => $qr['qrcode']['id'],
                                ]),
                            ) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
@elseif(request()->segment(2) == 'show-card')
    <table style="border: 1px solid; padding:25px">
        <tr>
            <td style="vertical-align: middle; height: 30px;">
                <img src="{{ public_path('img/card-asset/icon-logo.png') }}" class="img-fluid" alt="">
                <span class="fw-bold"
                        style="font-family: 'Baskervville', serif; padding-bottom:5px; vertical-align:middle; margin-left: 8px">{{ $user->office->name ?? 'Admin' }}</span>
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>
                <p class="fw-bold" style="font-family: 'Baskervville', serif; font-size: 30pt; line-height: 30px">
                    {{ $user->hasRole('admin') ? $user->admin->name : ($user->hasRole('supervisor') ? $user->supervisor->name : $user->employee->name) }}<br><span
                        style="font-size: 15pt"> {{ $user->position->name }}</span>
                </p>
            </td>
        </tr>
        <tr>
            <td style="border-top: 1px solid gray">
                <p class="fw-bold" style="font-family: 'Baskervville', serif; font-size: 12pt; line-height: 30px">
                    {{ $user->office->name ?? 'Admin' }} <br> {{ $user->office->address ?? '-' }} <br>
                    {{ $user->office->contact ?? '-' }}
                </p>
            </td>
            <td style="border-top: 1px solid gray">
                @if (!is_null($qr['qrcode']['redirect_link']))
                    <img
                        src="data:image/png;base64, {{ base64_encode(
                            QrCode::size(80)->generate(
                                route('master-qr.qr-processing', [
                                    'urlkey' => $qr['short_url']['url_key'],
                                    'qr_id' => $qr['qrcode']['id'],
                                ]),
                            ),
                        ) }} ">
                @else
                    <img
                        src="data:image/png;base64, {{ base64_encode(
                            QrCode::size(80)->generate(
                                route('master-qr.qr-vcard-processing', [
                                    'qr_id' => $qr['qrcode']['id'],
                                ]),
                            ),
                        ) }} ">
                @endif
            </td>
        </tr>
    </table>
@else
    <div class="border border-2 rounded">
        <div class="container my-3">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ asset('img/card-asset/icon-logo.png') }}" class="img-fluid" alt="">
                        <span class="mt-1 fw-bold"
                            style="font-family: 'Baskervville', serif;">{{ $user->office->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-12">
                    <p class="fw-bold" style="font-family: 'Baskervville', serif; font-size: 30pt; line-height: 30px">
                        {{ $user->hasRole('admin') ? $user->admin->name : ($user->hasRole('supervisor') ? $user->supervisor->name : $user->employee->name) }}
                        <br><span style="font-size: 15pt">{{ $user->position->name }}</span>
                    </p>
                </div>

            </div>
            <div class="border border-2 fw-bold"></div>
            <div class="row mt-2">
                <div class="col-10">
                    <p class="fw-bold" style="font-family: 'Baskervville', serif; font-size: 12pt; line-height: 30px">
                        {{ $user->office->name ?? 'Admin' }} <br> {{ $user->office->address ?? '-' }} <br>
                        {{ $user->office->contact ?? '-' }}
                    </p>
                </div>
                <div class="col-2">
                    @if (!is_null($qr['qrcode']['redirect_link']))
                        @if (request()->segment(2) == 'show-card')
                            <img
                                src="data:image/png;base64, {{ base64_encode(
                                    QrCode::size(80)->generate(
                                        route('master-qr.qr-processing', [
                                            'urlkey' => $qr['short_url']['url_key'],
                                            'qr_id' => $qr['qrcode']['id'],
                                        ]),
                                    ),
                                ) }} ">
                        @else
                            {!! QrCode::size(80)->generate(
                                route('master-qr.qr-processing', [
                                    'urlkey' => $qr['short_url']['url_key'],
                                    'qr_id' => $qr['qrcode']['id'],
                                ]),
                            ) !!}
                        @endif
                    @else
                        @if (request()->segment(2) == 'show-card')
                            <img
                                src="data:image/png;base64, {{ base64_encode(
                                    QrCode::size(80)->generate(
                                        route('master-qr.qr-vcard-processing', [
                                            'qr_id' => $qr['qrcode']['id'],
                                        ]),
                                    ),
                                ) }} ">
                        @else
                            {!! QrCode::size(80)->generate(
                                route('master-qr.qr-vcard-processing', [
                                    'qr_id' => $qr['qrcode']['id'],
                                ]),
                            ) !!}
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
