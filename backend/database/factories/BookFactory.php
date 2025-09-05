<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'Titulo' => $this->faker->text(40),
            'Editora' => $this->faker->company(),
            'Edicao' => $this->faker->numberBetween(1, 10),
            'AnoPublicacao' => $this->faker->year(),
            'valor' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}
