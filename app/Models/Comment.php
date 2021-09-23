<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded;

    public function creator()
    {
        $result = $this->belongsTo(User::class, 'user_id')
            ->select('name')        // , 'created_at'
//            ->withDefault(
//                function ($user) {
//                    $user->name = 'Guest Author';
//                }
//            )
//            ->withDefault([
//                'name' => 'Guest Author!',
//            ])
        ;

//        if ($result->count() === 0) {
//            $result = new \stdClass();
//            $result->name = null;
//        }
//        dd($result);
//        dd($result->count());
//        dd($result->getRelated());
//        dd($result->getRelationName());
//        dd(isset($result->related));
        return $result;
    }

    public function getImagePathAttribute()
    {
        return Storage::disk('custom_01')->url($this->image);
    }

//    public function deleteConfirmText()
//    {
//        dd($this);
//        return Str::replaceFirst('#{commentId}', $this->id, '#{commentId}번 댓글을 삭제하시겠습니까?');
//    }
}
