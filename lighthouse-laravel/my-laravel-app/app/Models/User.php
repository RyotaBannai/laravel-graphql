<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use App\Scopes\ActiveScope;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',  // 'datetime:Y-m-d' 日付のフォーマットも指定できる
        // 'options' => 'array',            // 例えば、options属性 がjson形式にシリアライズされている時に、取り出し時点で自動でarray型にキャスト
                                            // options属性へ値をセットすると配列は保存のために自動的にJSONへシリアライズ
    ];

    protected static function boot()
    {
        parent::boot();
        // static::addGlobalScope(new ActiveScope);
    }

    public function isAdmin($group_id)
    {
        return $this->groups->where('id', $group_id)->where('name', 'Admin')->count() > 0; // App\Models\User::find(9)->isAdmin(2)
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function groups()
    {
        return $this
            ->belongsToMany(Group::class, 'user_group', 'user_id', 'group_id')
            ->using(UserGroup::class)->withPivot(['role_id']);

        // user とgroupの中間テーブルなので自動的にそのカラムは取得できるが
        // 中間テーブルにあるその他のデータを取得したいときは withPivotで指定。
    }

    public function getData(){
        return $this->name.': '.$this->email;
    }

    // accessor $this->first_name;
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function scopeSignUpSince2000($query)
    {
        return $query->SignUpSince(2000);
        // App\Models\User::SignUpSince2000()->get()
    }

    public function scopeSignUpSince($query, $year)
    {
        $_year = Carbon::parse("first day of January $year");
        return $query->where('created_at', '>=', $_year);
    }
}
