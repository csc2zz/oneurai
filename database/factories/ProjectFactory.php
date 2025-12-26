<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true); // اسم مكون من 3 كلمات

        return [
            // نربط المشروع بمستخدم عشوائي أو نحدد لاحقاً
            'user_id' => User::factory(),

            'title' => $title,
            'slug' => Str::slug($title), // تحويل الاسم لرابط (saudi-llm-v1)
            'description' => fake()->paragraph(2),

            // نوع عشوائي (مستودع، نموذج، أو بيانات)
            'type' => fake()->randomElement(['repo', 'model', 'dataset']),

            'is_public' => fake()->boolean(80), // 80% احتمال يكون عام
            'language' => fake()->randomElement(['Python', 'PHP', 'JavaScript', 'HTML', 'Jupyter Notebook']),
            'license' => fake()->randomElement(['MIT', 'Apache 2.0', 'GPLv3']),

            'stars_count' => fake()->numberBetween(0, 5000),
            'views_count' => fake()->numberBetween(100, 50000),
        ];
    }
}
