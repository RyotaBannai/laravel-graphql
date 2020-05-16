<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        // static::addGlobalScope(new ActiveScope);
    }

    public function isAdmin($group_id)
    {
        return $this->groups->where('id', $group_id)->where('name', 'Admin')->count() > 0;
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function groups(): BelongsToMany
    {
        return $this
            ->belongsToMany(Group::class, 'user_group', 'user_id', 'group_id')
            ->using(UserGroup::class)->withPivot(['role_id']);
    }

    public function getData(): string
    {
        return $this->name.': '.$this->email;
    }

    public function getNameAttribute($value): string
    {
        return ucfirst($value);
    }

    public function scopeSignUpSince2000($query)
    {
        return $query->SignUpSince(2000);
    }

    public function scopeSignUpSince($query, $year)
    {
        $_year = Carbon::parse("first day of January $year");
        return $query->where('created_at', '>=', $_year);
    }

//    public function createUser(
//        $name,
//        $email,
//        $password,
//        $active=1): void
//    {
//        $this->create([
//            'name' => $name,
//            'email' => $email,
//            'password' => $password,
//            'active' => $active
//        ]);
//    }
}
