<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrinterSettings extends Model
{
    protected $fillable = ['os', 'name_printer'];
}
