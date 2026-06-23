<?php

namespace Tests\Feature;

use App\Models\Unit;
use App\Models\UnitConversion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnitConversionTest extends TestCase
{
    use RefreshDatabase;

    private Unit $kg;
    private Unit $g;

    protected function setUp(): void
    {
        parent::setUp();

        // Create base units for testing
        $this->kg = Unit::create(['name' => 'Kilogram', 'symbol' => 'Kg']);
        $this->g = Unit::create(['name' => 'Gram', 'symbol' => 'g']);
    }

    public function test_can_list_unit_conversions(): void
    {
        UnitConversion::create([
            'parent_unit_id' => $this->kg->id,
            'child_unit_id' => $this->g->id,
            'factor' => 1000.0000,
        ]);

        $response = $this->getJson('/api/unit-conversations');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'unit_conversions' => [
                    '*' => [
                        'id',
                        'parent_unit_id',
                        'child_unit_id',
                        'factor',
                        'representation',
                        'parent_unit',
                        'child_unit',
                    ]
                ]
            ]);
    }

    public function test_can_create_unit_conversion(): void
    {
        $response = $this->postJson('/api/unit-conversations', [
            'parent_unit_id' => $this->kg->id,
            'child_unit_id' => $this->g->id,
            'factor' => 1000.0000,
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'message' => 'Unit conversion created successfully',
            ]);

        $this->assertDatabaseHas('unit_conversation', [
            'parent_unit_id' => $this->kg->id,
            'child_unit_id' => $this->g->id,
            'factor' => 1000.0000,
        ]);
    }

    public function test_can_show_unit_conversion(): void
    {
        $conversion = UnitConversion::create([
            'parent_unit_id' => $this->kg->id,
            'child_unit_id' => $this->g->id,
            'factor' => 1000.0000,
        ]);

        $response = $this->getJson("/api/unit-conversations/{$conversion->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Unit conversion retrieved successfully',
            ]);
    }

    public function test_can_update_unit_conversion(): void
    {
        $conversion = UnitConversion::create([
            'parent_unit_id' => $this->kg->id,
            'child_unit_id' => $this->g->id,
            'factor' => 1000.0000,
        ]);

        $response = $this->putJson("/api/unit-conversations/{$conversion->id}", [
            'factor' => 950.0000,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Unit conversion updated successfully',
            ]);

        $this->assertDatabaseHas('unit_conversation', [
            'id' => $conversion->id,
            'factor' => 950.0000,
        ]);
    }

    public function test_can_delete_unit_conversion(): void
    {
        $conversion = UnitConversion::create([
            'parent_unit_id' => $this->kg->id,
            'child_unit_id' => $this->g->id,
            'factor' => 1000.0000,
        ]);

        $response = $this->deleteJson("/api/unit-conversations/{$conversion->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Unit conversion deleted successfully',
            ]);

        $this->assertSoftDeleted('unit_conversation', [
            'id' => $conversion->id,
        ]);
    }
}
