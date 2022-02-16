<?php

namespace Brainstud\HasIdentifier\Tests\Unit;

use Brainstud\HasIdentifier\Tests\Models\TestModel;
use Brainstud\HasIdentifier\Tests\Models\TestModelUuid;
use Brainstud\HasIdentifier\Tests\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class HasIdentifierTest extends TestCase
{
    public function testCreatingModel()
    {
        $model = TestModel::create();
        $this->assertTrue(Uuid::isValid($model->identifier));
        $this->assertNull($model->uuid);
    }

    public function testCreatingModelUuid()
    {
        $model = TestModelUuid::create();
        $this->assertTrue(Uuid::isValid($model->uuid));
        $this->assertNull($model->identifier);
    }

    public function testReplicatingModel()
    {
        $model = TestModel::create();
        $replica = $model->replicate();
        $this->assertNull($replica->identifier);
        $replica->save();
        $this->assertTrue(Uuid::isValid($replica->identifier));
        $this->assertNotEquals($model->identifier, $replica->identifier);
    }

    public function testFindModelsByIdentifier()
    {
        TestModel::create();
        $model = TestModel::create();
        TestModel::create();

        $result = TestModel::findByIdentifier($model->identifier);

        $this->assertEquals($model->id, $result->id);
    }

    public function testScopeModelsByIdentifier()
    {
        TestModel::create();
        $model = TestModel::create();
        TestModel::create();

        $result = TestModel::identifiedBy($model->identifier)->first();

        $this->assertEquals($model->id, $result->id);
    }

    public function testFindOrFailByExistingIdentifier()
    {
        TestModel::create();
        $model = TestModel::create();
        TestModel::create();

        $result = TestModel::findOrFailByIdentifier($model->identifier);

        $this->assertEquals($model->id, $result->id);
    }

    public function testFindOrFailByNotExistingIdentifier()
    {
        $this->expectException(ModelNotFoundException::class);
        TestModel::findOrFailByIdentifier(Str::uuid())->first();
    }

    public function testGetIdentifierAttribute()
    {
        $model = TestModel::create();
        $this->assertEquals($model->identifier, $model->identifier_value);
    }

    public function testGetIdentifierAttributeUuid()
    {
        $model = TestModelUuid::create();
        $this->assertEquals($model->uuid, $model->identifier_value);
    }

    public function testGetShortIdentifierAttribute()
    {
        $model = TestModel::create();
        $this->assertStringContainsString($model->short_identifier, $model->identifier);
    }

    public function testGetShortIdentifierAttributeUuid()
    {
        $model = TestModelUuid::create();
        $this->assertStringContainsString($model->short_identifier, $model->uuid);
    }

    public function testRouteKeyName()
    {
        $model = TestModel::create();
        $this->assertEquals('identifier', $model->getRouteKeyName());
    }

    public function testRouteKeyNameUuid()
    {
        $model = TestModelUuid::create();
        $this->assertEquals('uuid', $model->getRouteKeyName());
    }

}