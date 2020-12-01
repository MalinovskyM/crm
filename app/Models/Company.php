<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use Notifiable;

    protected $fillable = [
        'id', 'name', 'status','tariff_plan_id','date_start_tariff','date_end_tariff','website','email','phone','address','account_hold','credits'
    ];
    protected $guard_name = 'api';

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $casts = [
        'date_start_tariff' => 'date:Y-m-d H:i:s',
        'date_end_tariff' => 'date:Y-m-d H:i:s',
    ];

    public function user(){
        return $this->hasMany(User::class);
    }
}
