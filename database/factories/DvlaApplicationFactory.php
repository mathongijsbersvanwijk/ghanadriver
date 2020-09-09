<?php
namespace Database\Factories;

use App\Models\DvlaApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

class DvlaApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DvlaApplication::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //'user_id' => 1,
            'name' => $this->faker->name,
            'license_class' => 'B',
            'dvla_center' => 'Koforidua',
            'service_type' => 'Standard',
            'payment_option' => 'MTN_MOMO',
            'comments' => $this->faker->realText,
        ];
    }
}
