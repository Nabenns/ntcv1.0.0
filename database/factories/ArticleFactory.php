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
        $title = fake()->unique()->sentence(5);
        $published = fake()->boolean(80);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'author' => fake()->name(),
            'summary' => fake()->paragraph(),
            'content' => collect(range(1, 5))
                ->map(fn () => '<p>'.fake()->paragraph(6).'</p>')
                ->implode("\n"),
            'thumbnail_path' => null,
            'is_published' => $published,
            'published_at' => $published ? fake()->dateTimeBetween('-2 years') : null,
        ];
    }
}
