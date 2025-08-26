<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * @property int $id
 * @property string $uuid
 * @property string $stored_name
 * @property string $original
 * @property string $mime_type
 * @property int $size
 * @property string $extension
 * @property string|null $password
 * @property int $download_count
 * @property int $view_count
 * @property string|null $uploader_ip
 * @property string|null $delete_token
 * @property string|null $expires_at
 * @property string|null $bulk_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files expired()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files notExpired()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files public()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereBulkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereDeleteToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereStoredName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereUploaderIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Files whereViewCount($value)
 * @mixin \Eloquent
 */
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
