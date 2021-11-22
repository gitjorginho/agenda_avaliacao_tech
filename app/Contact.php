<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    protected $fillable = [
        "name",
        "age",
        
    ];


    public function telephones(){
        return $this->HasMany(Telephone::class);
    }


}
