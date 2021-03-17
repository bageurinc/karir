<?php

namespace Bageur\Karir\Model;

use Illuminate\Database\Eloquent\Model;

class bookmark extends Model
{
    protected $table   = 'bgr_karir_bookmark';
    protected $fillable = ['karir_id','user_id'];

}
