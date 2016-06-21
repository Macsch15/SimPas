<?php

namespace SimPas\Repository;

use Illuminate\Database\Eloquent\Model;
use Auth;

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
     * Get author of pastebin
     *
     * @return SimPas\Repository\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if pastebin is edited
     *
     * @return bool|Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsEdited()
    {
        return $this->created_at->getTimestamp() !== $this->updated_at->getTimestamp();
    }

    /**
     * Check if current user is author of pastebin
     *
     * @return bool|Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsAuthor()
    {
        return Auth::check() && Auth::id() === $this->user_id;
    }
}
