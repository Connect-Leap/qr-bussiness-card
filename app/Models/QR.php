<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QR extends Model
{
    use HasFactory;

    protected $table = 'qrs';

    protected $guarded = ['id'];

    protected $with = ['user', 'qrContactType', 'qrVisitors'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function qrContactType()
    {
        return $this->belongsTo(QrContactType::class, 'qr_contact_type_id', 'id');
    }

    public function qrVisitors()
    {
        return $this->hasMany(QrVisitor::class, 'qr_id', 'id');
    }

    public function fileStorage()
    {
        return $this->belongsToMany(FileStorage::class, 'qr_file_storages', 'qr_id', 'file_storage_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }


}
