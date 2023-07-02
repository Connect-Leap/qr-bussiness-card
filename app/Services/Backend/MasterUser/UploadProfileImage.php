<?php

namespace App\Services\Backend\MasterUser;

use App\Models\User;
use App\Services\BaseService;
use App\Models\UserFileStorage;
use Illuminate\Support\Facades\DB;
use App\Services\BaseServiceInterface;
use Illuminate\Support\Facades\Storage;

class UploadProfileImage extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        DB::beginTransaction();

        try {
            $user = User::where('id', $dto['user_id'])->first();

            if (empty($user)) {
                $this->results['response_code'] = 404;
                $this->results['success'] = false;
                $this->results['message'] = "User Not Found";
                $this->results['data'] = [];
            } else {
                $profile_input_file = $dto['profile_image_file'];
                $profile_filename = "img-profile".'-'.time();

                $upsert_file_storage = app('UpsertUserProfileFileStorage')->execute([
                    'profile_image_file' => $dto['profile_image_file'],
                    'user_id' => $user->id,
                    'file_size' => $profile_input_file->getSize(),
                    'file_driver' => config('filesystems.default'),
                    'file_extension' => $profile_input_file->getClientOriginalExtension(),
                    'file_original_name' => $profile_input_file->getClientOriginalName(),
                    'file_name' => $profile_filename,
                    'file_path' => 'storage/app/public/profile-img/',
                    'file_type' => $profile_input_file->getClientMimeType(),
                    'file_url' => storageLinkFormatter('storage/profile-img', $profile_filename, $profile_input_file->getClientOriginalExtension()),
                    'is_used' => USED,
                ]);

                $this->results['response_code'] = 200;
                $this->results['success'] = true;
                $this->results['message'] = "Successfully Update User Profile";
                $this->results['data'] = [
                    'user' => $user,
                    'file_storage' => $upsert_file_storage['data']['file_storage'],
                    'pivot_table' => $upsert_file_storage['data']['pivot_table'],
                ];

                DB::commit();
            }
        } catch (\Exception $err) {

            DB::rollBack();

            $this->results['response_code'] = $err->getCode();
            $this->results['success'] = false;
            $this->results['message'] = $err->getMessage();
            $this->results['data'] = [];
        }
    }
}
