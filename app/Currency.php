<?php

namespace CurrencyConverter;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    
    protected $table = 'currencies';

    protected $fillable = ['currency', 'name', 'symbol'];


    public function rates()
    {
    	return $this->hasMany('CurrencyConverter\CurrencyRate', 'currency_id', 'id');
    }

    public function getSymbolUTF8Attribute()
    {
    	return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function($match) {
    		return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
    	}, $this['symbol']);
    }
}
