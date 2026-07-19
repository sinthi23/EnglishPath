<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('admin can create another admin from the website', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.users.store-admin'), [
        'name' => 'New Admin',
        'email' => 'new.admin@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('admin.users.index'));

    $this->assertDatabaseHas('users', [
        'name' => 'New Admin',
        'email' => 'new.admin@example.com',
        'role' => 'admin',
    ]);

    $createdUser = User::where('email', 'new.admin@example.com')->first();

    expect($createdUser)->not->toBeNull();
    expect(Hash::check('password123', $createdUser->password))->toBeTrue();
});
