<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(rand(3, 8), true);
        $txt = $this->faker->realText(rand(1000, 4000));
        $isPublished = rand(1, 5) > 1;

        $data =[
            'category_id' => rand(1, 11),
            'user_id' => (rand(1, 5) == 5)? 1 : 2,
            'title' => $title,
            'slug' =>  Str::of($title)->slug(),
            'excerpt' => $this->faker->text(rand(40, 100)),
            'content_raw' => $txt,
            'content_html' => $txt,
            'is_published' => $isPublished,
            'published_at' =>  $isPublished ?  $this->faker->dateTimeBetween('-2 months', '-1 days') : null,
            'created_at' => $this->faker->dateTimeBetween('-3 months', '-1 days'),
            'updated_at' =>  $this->faker->dateTimeBetween('-3 months', '-1 days')
        ];



        return $data;
    }
}
