<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(5);
        $published = $this->faker->boolean(80);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'author' => $this->faker->name(),
            'summary' => $this->faker->paragraph(),
            'content' => collect(range(1, 5))
                ->map(fn () => '<p>'.$this->faker->paragraph(6).'</p>')
                ->implode("\n"),
            'thumbnail_path' => null,
            'is_published' => $published,
            'published_at' => $published ? $this->faker->dateTimeBetween('-2 years') : null,
        ];
    }
}
