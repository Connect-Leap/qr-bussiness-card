<?php

namespace App\Services\Backend\FileStorage;

use App\Models\User;
use App\Models\FileStorage;
use App\Services\BaseService;
use App\Models\UserFileStorage;
use App\Services\BaseServiceInterface;
use Illuminate\Support\Facades\Storage;

class UpsertUserProfileFileStorage extends BaseService implements BaseServiceInterface
{
    public function process($dto)
    {
        $user = User::where('id', $dto['user_id'])->first();

        if (empty($user)) {
            $this->results['response_code'] = 404;
            $this->results['success'] = false;
            $this->results['message'] = "User Not Found";
            $this->results['data'] = [];
        } else {
            $old_user_profile_pictures_pivot = UserFileStorage::where('user_id', $dto['user_id'])->pluck('file_storage_id')->toArray();

            if (count($old_user_profile_pictures_pivot) > 0) {
                foreach ($old_user_profile_pictures_pivot as $old_user_profile_picture) {
                    $old_user_profile_picture_file_storage = FileStorage::where('id', $old_user_profile_picture)->first();

                    $file_path = '/public/profile-img/'.$old_user_profile_picture_file_storage->file_name;

                    if (Storage::disk(config('filesystems.default'))->exists($file_path)) {
                        Storage::disk(config('filesystems.default'))->delete($file_path);
                    } else {
                        $this->results['response_code'] = 404;
                        $this->results['success'] = false;
                        $this->results['message'] = "File doesnt exists";
                        $this->results['data'] = [];
                    }

                    $old_user_profile_picture_file_storage->delete();

                    $user->fileStorage()->detach();
                }

                $profile_input_file = $dto['profile_image_file'];

                $profile_filename = "img-profile".'-'.time();

                $file_storage = app('StoreToFileStorage')->execute([
                    'file_size' => $dto['file_size'],
                    'file_driver' => $dto['file_driver'],
                    'file_extension' => $dto['file_extension'],
                    'file_original_name' => $dto['file_original_name'],
                    'file_name' => $dto['file_name'],
                    'file_path' => $dto['file_path'],
                    'file_type' => $dto['file_type'],
                    'file_url' => $dto['file_url'],
                    'is_used' => $dto['is_used'],
                ]);

                $store_to_pivot = UserFileStorage::create([
                    'user_id' => $dto['user_id'],
                    'file_storage_id' => $file_storage['data']['file_storage_id'],
                ]);

                Storage::disk(config('filesystems.default'))->put('/public/profile-img/'.$profile_filename.'.'.$profile_input_file->getClientOriginalExtension(), file_get_contents($profile_input_file->getRealPath()));

                $this->results['response_code'] = 200;
                $this->results['success'] = true;
                $this->results['message'] = "Successfully Stored to File Storage";
                $this->results['data'] = [
                    'user' => $user,
                    'file_storage' => $file_storage,
                    'pivot_table' => $store_to_pivot,
                ];

            } else {
                $profile_input_file = $dto['profile_image_file'];

                $profile_filename = "img-profile".'-'.time();

                $file_storage = app('StoreToFileStorage')->execute([
                    'file_size' => $dto['file_size'],
                    'file_driver' => $dto['file_driver'],
                    'file_extension' => $dto['file_extension'],
                    'file_original_name' => $dto['file_original_name'],
                    'file_name' => $dto['file_name'],
                    'file_path' => $dto['file_path'],
                    'file_type' => $dto['file_type'],
                    'file_url' => $dto['file_url'],
                    'is_used' => $dto['is_used'],
                ]);

                $store_to_pivot = UserFileStorage::create([
                    'user_id' => $dto['user_id'],
                    'file_storage_id' => $file_storage['data']['file_storage_id'],
                ]);

                Storage::disk(config('filesystems.default'))->put('/public/profile-img/'.$profile_filename.'.'.$profile_input_file->getClientOriginalExtension(), file_get_contents($profile_input_file->getRealPath()));

                $this->results['response_code'] = 200;
                $this->results['success'] = true;
                $this->results['message'] = "Successfully Stored to File Storage";
                $this->results['data'] = [
                    'user' => $user,
                    'file_storage' => $file_storage,
                    'pivot_table' => $store_to_pivot,
                ];
            }
        }

    }
}
