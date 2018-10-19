<?php

namespace App\Models\Adverts\Advert\Dialog;

use App\Models\Adverts\Advert;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Adverts\Advert\Dialog\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
/**
 * @property int $id
 * @property int $advert_id
 * @property int $owner_id
 * @property int $client_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $user_new_messages
 * @property int $client_new_messages
 */
class Dialog extends Model
{
    protected $table = 'advert_dialogs';

    protected $guarded = ['id'];

    public function writeMessageByOwner(string $message): void
    {
        $this->messages()->create([
            'user_id' => $this->owner_id,
            'dialog_id' => $this->id,
            'message' => $message,
        ]);
        $this->client_new_messages++;
        $this->save();
    }

    public function writeMessageByClient(string $message): void
    {
        $this->messages()->create([
            'user_id' => $this->client_id,
            'dialog_id' => $this->id,
            'message' => $message,
        ]);
        $this->user_new_messages++;
        $this->save();
    }

    public function readByOwner(): void
    {
        $this->update(['user_new_messages' => 0]);
    }

    public function readByClient(): void
    {
        $this->update(['client_new_messages' => 0]);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function advert()
    {
        return $this->belongsTo(Advert::class, 'advert_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'dialog_id', 'id');
    }

    public function scopeMyDialogs(Builder $query)
    {
        return  $query->where('owner_id', Auth::id())->orWhere('client_id', Auth::id());
    }
}
