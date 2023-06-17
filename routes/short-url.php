<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\Admin\QR\QrController;

Route::get('/short/{urlkey}/{qr_id}', [QrController::class, 'QrProcessing'])->name('master-qr.qr-processing');
Route::get('/short/{qr_id}/vcard/process', [QrController::class, 'QrVcardProcessing'])->name('master-qr.qr-vcard-processing');
