<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Kind;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Ticket;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTime(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text,
            'kind_id' => Kind::factory(),
            'category_id' => Category::factory(),
            'priority_id' => Priority::factory(),
            'status_id' => Status::factory(),
            'employee_id' => Employee::factory(),
        ];
    }
}
