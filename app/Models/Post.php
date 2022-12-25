<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Kyslik\ColumnSortable\Sortable;
use function Illuminate\Events\queueable;

class Post extends Model
{
    use HasFactory;
    use Sortable;

    protected $guarded = ['id'];

    protected $appends = ['user_name'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(queueable(function () {
            Cache::forget(static::getCacheKey());
        }));
    }

    public $sortable = ['published_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getUserNameAttribute() {
        return $this->user()->first()->name;
    }

    public static function getCacheKey() {
        return Post::sortable()->toSql()."page=".request()->get('page');
    }
}
