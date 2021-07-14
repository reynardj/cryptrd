<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class TelegramBotLog extends BaseModel {

    use SoftDeletes;

    const CREATED_AT = "created_at";
    const UPDATED_AT = "modified_at";

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->created_by = self::get_userstamp();
        });

        static::saving(function($model) {
            $model->modified_by = self::get_userstamp();
        });

        static::deleting(function($model) {
            $model->deleted_by = self::get_userstamp();
            $model->save();
        });
    }

    protected $table = "telegram_bot_log";

    protected $primaryKey = "telegram_bot_log_id";

    protected $fillable = [];

    // Mutators
    protected $dates = [
        'created_at',
        'modified_at',
        'deleted_at'
    ];

    // Attribute Casting
    protected $casts = [];

    // Validation rules
    public static $rules = [];

}
