<?php

namespace Tags;

use Illuminate\Database\Eloquent\Model;
use Ivy\Shared\Traits\HasPolicies;

class Tag extends Model
{
    use HasPolicies;

    protected $fillable = [
        'value',
    ];
}
