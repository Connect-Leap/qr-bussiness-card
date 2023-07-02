<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFileStorage extends Model
{
    use HasFactory;

    protected $table = 'user_file_storages';

    protected $guarded = ['id'];
}
