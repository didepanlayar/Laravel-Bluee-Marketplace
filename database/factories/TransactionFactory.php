<?php

namespace Database\Factories;

use App\Models\Buyer;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shippingTypes = ['regular', 'express', 'same_day'];
        $shippingType = $this->faker->randomElement($shippingTypes);

        $shippingCost = match ($shippingType) {
            default => $this->faker->numberBetween(10000, 20000),
            'regular' => $this->faker->numberBetween(10000, 20000),
            'express' => $this->faker->numberBetween(20000, 30000),
            'same_day' => $this->faker->numberBetween(30000, 50000),
        };

        return [
            'code' => 'TRX-' . $this->faker->unique()->numerify('########'),
            'buyer_id' => Buyer::factory(),
            'store_id' => Store::factory(),
            'address_id' => $this->faker->numberBetween(1, 1000),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'shipping' => $this->faker->randomElement(['JNE', 'TIKI', 'POS', 'GOJEK', 'GRAB']),
            'shipping_type' => $shippingType,
            'shipping_cost' => $shippingCost,
            'tax' => 0, // Will be calculated after transaction details
            'grand_total' => 0, // Will be calculated after transaction details
            'payment_status' => $this->faker->randomElement(['unpaid', 'paid']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Transaction $transaction) {
            $numberDetails = $this->faker->numberBetween(1, 5);
            $subtotal = 0;

            for ($i=0; $i < $numberDetails; $i++) {
                $product = Product::factory()->create(['store_id' => $transaction->store_id]);
                $quantity = $this->faker->numberBetween(1, 5);
                $subtotal += $product->price * $quantity;

                TransactionDetail::factory()->create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity,
                ]);
            }

            // Calculated tax (11% of subtotal)
            $tax = round($subtotal) * 0.11;

            // Calculate grand total
            $granTotal = $subtotal + $tax + $transaction->shipping_cost;

            $transaction->update([
                'tax' => $tax,
                'grand_total' => $granTotal,
            ]);
        });
    }
}
