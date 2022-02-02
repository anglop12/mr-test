<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'url',
        //Aqui tuve un error
        // 'attachment_id',
        // 'attachment_type'
        'attachmentable_id',
        'attachmentable_type',
    ];

    public function attachmentable()
    {
        return $this->morphTo();
    }
}
