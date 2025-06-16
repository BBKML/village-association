<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 
        'value', 
        'type',  // Optional: to distinguish setting types (text, boolean, file, etc.)
        'description'
    ];

    /**
     * Scope to get a setting by its key
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $key
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function scopeGetByKey($query, $key)
    {
        return $query->where('key', $key)->first();
    }

    /**
     * Helper method to get a setting value
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}