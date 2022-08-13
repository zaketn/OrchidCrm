<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    /**
     * Ensure the year display if it not matches the current year
     * The Project model has been taken for example, could be swapped to any
     *
     * @return void
     */
    public function test_datetime_format()
    {
        $recentProject = Project::factory()->create();
        $this->assertEquals(
            Carbon::create($recentProject->created_at)->translatedFormat('j F, g:i'),
            datetime_format($recentProject->created_at)
        );

        $oldProject = Project::factory()->create([
            'created_at' => Carbon::now()->addYear()
        ]);
        $this->assertEquals(
            Carbon::create($oldProject->created_at)->translatedFormat('j F Y, g:i'),
            datetime_format($oldProject->created_at)
        );

        $mysteriousProject = Project::factory()->create([
            'created_at' => null,
        ]);
        $this->assertEquals('-', datetime_format($mysteriousProject->created_at));
    }
}
