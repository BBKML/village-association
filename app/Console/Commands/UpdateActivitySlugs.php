<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use Illuminate\Support\Str;

class UpdateActivitySlugs extends Command
{
    protected $signature = 'activities:update-slugs';
    protected $description = 'Update slugs for all activities';

    public function handle()
    {
        $activities = Activity::all();
        $count = 0;

        foreach ($activities as $activity) {
            if (empty($activity->slug)) {
                $activity->slug = Str::slug($activity->title);
                $activity->save();
                $count++;
            }
        }

        $this->info("Updated {$count} activities with new slugs.");
    }
} 