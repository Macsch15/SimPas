<?php

namespace SimPas\Repository;

use Illuminate\Database\Eloquent\Model;

class PastebinRecord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_id', 'user_id', 'title', 'content'
    ];

    /**
     * Get author of paste
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
