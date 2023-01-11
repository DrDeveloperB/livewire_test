<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class SupportTicket extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $guarded;

    public function creator()
    {
        $result = $this->belongsTo(User::class, 'user_id')
            ->select('name')        // , 'created_at'
        ;

        return $result;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->select('id', 'user_id', 'comment', 'created_at');
    }

    public function getImagePathAttribute()
    {
//        var_dump(Storage::disk('ticket')->exists($this->image));
        if (Storage::disk('ticket')->exists($this->image)) {
            return Storage::disk('ticket')->url($this->image);
        }
        return '';
    }
}
