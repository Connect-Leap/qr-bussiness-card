<?php

use Illuminate\Support\Facades\Route;

Route::get('/short/{urlkey}/{qr_id}', [QrController::class, 'QrProcessing'])->name('master-qr.qr-processing');
Route::get('/short/{qr_id}/vcard/process', [QrController::class, 'QrVcardProcessing'])->name('master-qr.qr-vcard-processing');
