<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $uuid
 * @property string $stored_names
 * @property string $title
 * @property string $mime_type
 * @property int $size
 * @property string $extension
 * @property string|null $password
 * @property string|null $expires_at
 * @property int $download_count
 * @property int $view_count
 * @property string|null $delete_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin whereDeleteToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin whereStoredNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pastebin whereViewCount($value)
 * @mixin \Eloquent
 */
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
