<?php

namespace Brainstud\HasIdentifier\Tests\Models;

use Brainstud\HasIdentifier\HasIdentifier;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use HasIdentifier;

    protected $guarded = [];
}
