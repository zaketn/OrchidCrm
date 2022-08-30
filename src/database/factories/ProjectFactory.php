<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Orchid\Attachment\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $statuses = collect([
            Project::STATUS_STARTED,
            Project::STATUS_FINISHED,
            Project::STATUS_CANCELLED,
            Project::STATUS_STOPPED
        ]);

        return [
            'name' => fake()->unique()->lexify('Project ??????'),
            'status' => $statuses->random(),
            'repo_link' => fake()->unique()->url()
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function(Project $project){
            $contractName = Str::random() .'.pdf';
            $contractFile = UploadedFile::fake()->create($contractName, 0, 'application/pdf');

            (new File($contractFile))->load();
            $attachmentIndex = DB::table('attachments')->latest('id')->pluck('id')->first();

            $project->contract = $attachmentIndex;
            $project->save();

            $project->attachment()->sync($attachmentIndex);
        });
    }
}
