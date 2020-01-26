<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class loan extends Model
{
  protected $fillable = [
      'amount','term','interest','rate','start_date','updated_at','created_at',
  ];
}
