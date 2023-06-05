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


}
