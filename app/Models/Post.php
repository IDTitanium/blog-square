<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    use HasFactory;
    use Sortable;

    protected $guarded = ['id'];

    protected $appends = ['user_name'];

    public $sortable = ['published_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getUserNameAttribute() {
        return $this->user()->first()->name;
    }
}
