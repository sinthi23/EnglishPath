<?php

use App\Models\User;

test('admin pages send no-cache headers', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk();
    expect($response->headers->get('Cache-Control'))->toContain('no-cache');
    expect($response->headers->get('Cache-Control'))->toContain('no-store');
    expect($response->headers->get('Cache-Control'))->toContain('must-revalidate');
    expect($response->headers->get('Cache-Control'))->toContain('private');
    $response->assertHeader('Pragma', 'no-cache');
    $response->assertHeader('Expires', '0');
});
