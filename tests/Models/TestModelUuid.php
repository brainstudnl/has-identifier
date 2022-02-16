<?php

namespace Brainstud\HasIdentifier\Tests\Models;

use Brainstud\HasIdentifier\HasIdentifier;
use Illuminate\Database\Eloquent\Model;

class TestModelUuid extends Model
{
    use HasIdentifier;

    protected $table = 'test_models';

    protected string $identifierAttribute = 'uuid';

    protected $guarded = [];
}