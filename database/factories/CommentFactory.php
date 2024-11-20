<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Определяет стандартное состояние модели.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(), // Генерирует случайное слово для имени
            'desc' => $this->faker->paragraph(), // Генерирует случайный параграф для описания
            'user_id' => User::factory(), // Использует фабрику User для генерации случайного пользователя
            'article_id' => \App\Models\Article::factory(), // Если у вас есть модель Article, также можно использовать фабрику для связи
        ];
    }
}

