<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Files extends Model
{
    // Table name
    protected $table = 'files';

    // Mass assignable attributes
    protected $fillable = [
        'uuid',
        'stored_name',
        'original'.
        'mime_type',
        'size',
        'extension',
        'password',
        'download_count',
        'view_count',
        'uploader_ip',
        'delete_token',
        'expires_at',
    ];

    // Casts
    protected function cast(){
        [
        'expires_at' => 'datetime',
        'download_count' => 'integer',
        'view_count' => 'integer',
        'size' => 'integer',
        ];}

    // Boot method to auto-generate UUID and delete_token

    // Scope: Only public files
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // Scope: Expired files
    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')->where('expires_at', '<', Carbon::now());
    }

    // Scope: Not expired files
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')->orWhere('expires_at', '>', Carbon::now());
        });
    }


    // Increment download count
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }

    // Increment view count
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    // Check if file is password protected
    public function isPasswordProtected()
    {
        return !empty($this->password);
    }

    // Hide sensitive attributes
    protected $hidden = [
        'password',
        'delete_token',
        'uploader_ip',
    ];
}
