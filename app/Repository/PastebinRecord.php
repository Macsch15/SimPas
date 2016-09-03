<?php

namespace SimPas\Repository;

use Auth;
use Illuminate\Database\Eloquent\Model;

class PastebinRecord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_id', 'user_id', 'title', 'content',
    ];

    /**
     * Get author of pastebin.
     *
     * @return SimPas\Repository\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if pastebin is edited.
     *
     * @return bool
     */
    public function isEdited()
    {
        return $this->created_at->getTimestamp() !== $this->updated_at->getTimestamp();
    }

    /**
     * Check if current user is author of pastebin.
     *
     * @return bool
     */
    public function isAuthor()
    {
        return Auth::check() && Auth::id() === $this->user_id;
    }

    /**
     * Check if pastebin is created by user.
     *
     * @return bool
     */
    public function createdByUser()
    {
        return $this->user_id !== 0;
    }
}
