<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pastebin extends Model
{
    protected $table = "pastebins";

    protected $fillable = [
        'uuid',
        'stored_names',
        'title',
        'mime_type',
        'size',
        'extension',
        'password',
        'expires_at',
        'download_count',
        'view_count',
        'delete_token',
    ];

    protected function cast(){
        [
        'expires_at' => 'datetime',
        'download_count' => 'integer',
        'view_count' => 'integer',
        'size' => 'integer',
        ];}
}
