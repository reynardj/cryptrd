<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Ticker extends BaseModel {

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

    protected $table = "ticker";

    protected $primaryKey = "ticker_id";

    protected $fillable = [];

    // Accessors & Mutators
    protected $dates = [
        'created_at',
        'modified_at',
        'deleted_at'
    ];

    // Attribute Casting
    protected $casts = [
        'ticker_id' => 'int',
        'ticker_name' => 'string',
        'created_by' => 'string',
        'created_at' => 'datetime',
        'modified_by' => 'string',
        'modified_at' => 'datetime',
        'deleted_by' => 'string',
        'deleted_at' => 'datetime'
    ];

    // Validation rules
    public static $rules = [];

    // Relationships
}
