<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait QrFileStorageTrait
{
    public function storeQrToStorageDisk(string $generate_url)
    {
        try {
            $image = QrCode::format('png')->size(300)->generate($generate_url);

            $path = '/public/qr-code/';

            $output_file = "img-" . time() . '.png';

            $explode_outputfile = explode('.', $output_file);

            $filename = $explode_outputfile[0];
            $extension = $explode_outputfile[1];

            Storage::disk(config('filesystems.default'))->put($path.$output_file, $image);

        } catch (\Exception $err) {
            throw new Exception($err->getMessage(), $err->getCode());
        }

        return [
            'image_var' => $image,
            'output_file' => $output_file,
            'path' => $path,
            'filename' => $filename,
            'extension' => $extension,
        ];
    }
}
