<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;
    protected $fillable=['url','imageable_id','imageable_type'];

    public function imageable()
    {
        return $this->morphTo();
    }
    public function deleteImage(){

        Storage::delete($this->url);

    }
}
