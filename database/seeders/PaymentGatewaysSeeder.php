<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PaymentGateway;

class PaymentGatewaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a user
        // $user = User::factory()->create();

        // Create payment gateways for the user
        PaymentGateway::create([
            'user_id' => 1,
            'name' => 'PaymentGateway1',
            'api_key_paytabs' => 'SDJNBZH9T9-JDGBLW9GDL-2W2W6TW2N2',
            'profile_id_paytabs' => '87757',
            'client_key' => 'client_key_1',
        ]);

        // You can add more payment gateways for testing if needed
    }
}
