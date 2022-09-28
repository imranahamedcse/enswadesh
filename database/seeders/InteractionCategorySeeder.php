<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Interaction\InteractionCategory;

class InteractionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = array('Video', 'Template' , 'Real Experience', 'Meme', 'Story');

        foreach($titles as $title)
        {
            InteractionCategory::updateOrCreate([
                'title' => $title,
                'slug' => Str::of($title)->slug('-')
            ]);
        }

    }
}
