<?php
namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'dvla_application_id' => 1,
            'momo_transaction_id' => $this->faker->uuid,
            'status' => 'SUCCESSFUL',
            'amount' => $this->faker->randomFloat(2, 0, 1000),
            'payer_message' => $this->faker->realText,
            'payee_note' => $this->faker->realText,
        ];
    }
}
