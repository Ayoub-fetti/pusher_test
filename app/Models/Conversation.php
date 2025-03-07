<?php

namespace App\Models;

use App\Models\Message;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['title'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_user')
            ->withPivot('last_read_at')
            ->withTimestamps();
    } 
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }
    public function unreadMessagesFor(User $user)
    {
        return $this->messages()
            ->where('user_id', '!=', $user->id)
            ->where('created_at', '>', function ($query) use ($user) {
                $query->select('last_read_at')
                    ->from('conversation_user')
                    ->where('conversation_id', $this->id)
                    ->where('user_id', $user->id);
            })
            ->count();
    }
}
