<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Label;
use App\Models\User;

class LabelControllerTest extends TestCase
{
    private User $user;
    private Label $label;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->label = Label::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('labels.index'));
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('labels.create'));
        $response->assertStatus(200);
    }

    public function testEdit()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('labels.edit', $this->label));
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $this->actingAs($this->user);
        $data = $this->label->only(['name', 'description']);
        $response = $this
            ->patch(route('labels.update', $this->label), $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('labels', $data);
    }

    public function testDestroy()
    {
        $this->actingAs($this->user);
        $this->assertDatabaseHas('labels', ['id' => $this->label->id]);
        $response = $this->delete(route('labels.destroy', $this->label));
        $response->assertRedirect();
        $this->assertDatabaseMissing('labels', ['id' => $this->label->id]);
    }

    public function testStore()
    {
        $this->actingAs($this->user);
        $response = $this->post(route('labels.store'), $this->label->toArray());
        $this->assertDatabaseHas('labels', $this->label->toArray());
        $response->assertRedirect();
    }

    public function testGuestCanNotStore()
    {
        $hadBeen = Label::count();
        $response = $this->post(route('labels.store'), $this->label->toArray());
        $became = Label::count();
        $this->assertEquals($hadBeen, $became);
    }

    public function testGuestCanNotUpdate()
    {
        $oldValue = $this->label->name;
        $updatedValue = implode(' ', ["Updated Title", rand()]);
        $this->label->name = $updatedValue;
        $this->patch(route('labels.update', $this->label), $this->label->toArray());
        $this->assertDatabaseHas('labels', ['id' => $this->label->id , 'name' => $oldValue]);
    }

    public function testGuestCanNotDelete()
    {
        $this->assertDatabaseHas('labels', ['id' => $this->label->id]);
        $this->delete(route('labels.destroy', $this->label));
        $this->assertDatabaseHas('labels', ['id' => $this->label->id]);
    }
}
