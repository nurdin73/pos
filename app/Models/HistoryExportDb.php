<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryExportDb extends Model
{
    use HasFactory;

    protected $fillable = ['whoExport', 'nama_file'];
}
