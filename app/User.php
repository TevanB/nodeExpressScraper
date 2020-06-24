<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens ,LaravelVueDatatableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'bio', 'photo', 'type', 'payout', 'ongoing_orders', 'ongoing_orders_arr','current_orders_arr', 'completed_orders',
    ];
    protected $dataTableColumns = [
            'id' => [
                'searchable' => false,
            ],
            'name' => [
                'searchable' => true,
            ],
            'email' => [
                'searchable' => true,
            ],
            'type' => [
                'searchable' => true,
            ],
            'created_at' => [
                'searchable' => true,
            ]
        ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'ongoing_orders_arr' =>'array',
        'current_orders_arr' =>'array',
    ];


    /**
     * A user can have many messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
      return $this->hasMany(Message::class);
    }
}
