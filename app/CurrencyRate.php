<?php

namespace CurrencyConverter;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CurrencyRate extends Model
{
    protected $table = 'currency_rates';

    protected $fillable = ['currency_id', 'rate', 'for_date'];


    public function scopeForDate($query, Carbon $date)
    {
    	$query->where('for_date', '>=', $date->format('Y-m-d 00:00:00'))
    		  ->where('for_date', '<=', $date->format('Y-m-d 23:59:59'));
    }

    public function scopeLatest($query)
    {
    	$date = self::getMaxForDate();

    	$this->scopeForDate($query, $date);
    }

    public function scopeForToday($query)
    {
    	$now = Carbon::now();

    	$this->scopeForDate($query, $now);
    }

    public function currency()
    {
    	return $this->hasOne('CurrencyConverter\Currency', 'id', 'currency_id');
    }

    public function getCurrencyAndNameAttribute()
    {
    	return $this['currency']['currency'] . ' ' . $this['currency']['name'];
    }

    public static function getMaxForDate()
    {
    	$max = self::max('for_date');
    	return Carbon::createFromTimestamp(strtotime($max));
    }
}
