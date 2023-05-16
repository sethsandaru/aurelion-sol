<?php

namespace Tests\Feature;

use Tests\TestCase;

class PullHotelsCommandTest extends TestCase
{
    public function testCommandPullsTheHotelsAndMergesTheData()
    {
        $this->artisan('hotels:pull')
            ->expectsOutputToContain('Retrieving & Merging for Service Rainy')
            ->expectsOutputToContain('Retrieving & Merging for Service Sunny')
            ->expectsOutputToContain('Retrieving & Merging for Service Windy')
            ->assertOk();

        $this->assertDatabaseHas('hotels', [
            'name' => 'Beach Villas Singapore',
        ]);
        $this->assertDatabaseHas('hotels', [
            'name' => 'InterContinental Singapore Robertson Quay',
        ]);
        $this->assertDatabaseHas('hotels', [
            'name' => 'Hilton Shinjuku Tokyo',
        ]);
    }
}
