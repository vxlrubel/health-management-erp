<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Client;
use App\Models\Funder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $branches = Branch::all();
        $clients = Client::all();
        $funders = Funder::all();

        foreach ($branches as $branch) {
            $branchClients = $clients->where('branch_id', $branch->id);

            foreach ($branchClients as $client) {
                for ($i = 0; $i < 3; $i++) {
                    $invNumber = 'INV-' . strtoupper($branch->code) . '-' . str_pad((string) ($client->id * 10 + $i), 4, '0', STR_PAD_LEFT);
                    $dueDate = \Carbon\Carbon::now()->addDays(30 * ($i - 1));
                    $amount = $faker->randomFloat(2, 500, 5000);
                    $tax = round($amount * 0.2, 2);
                    $total = $amount + $tax;

                    $invoice = Invoice::firstOrCreate(
                        ['invoice_number' => $invNumber],
                        [
                            'uuid' => \Illuminate\Support\Str::uuid(),
                            'invoice_type' => $faker->randomElement(['care', 'consultation', 'transport', 'support']),
                            'client_id' => $client->id,
                            'funder_id' => $funders->random()->id,
                            'amount' => $amount,
                            'tax' => $tax,
                            'discount' => $faker->randomFloat(2, 0, 100),
                            'total' => $total,
                            'paid_amount' => $i < 1 ? $total : 0,
                            'balance' => $i < 1 ? 0 : $total,
                            'status' => $i < 1 ? 'paid' : ($i < 2 ? 'pending' : 'draft'),
                            'due_date' => $dueDate->format('Y-m-d'),
                            'paid_date' => $i < 1 ? now()->subDays(rand(1, 15))->format('Y-m-d') : null,
                        ]
                    );

                    for ($j = 0; $j < rand(1, 3); $j++) {
                        $itemAmount = $faker->randomFloat(2, 100, 500);
                        $itemTax = round($itemAmount * 0.2, 2);
                        InvoiceItem::firstOrCreate(
                            ['invoice_id' => $invoice->id, 'description' => "Care service item " . ($j + 1)],
                            [
                                'uuid' => \Illuminate\Support\Str::uuid(),
                                'description' => $faker->randomElement([
                                    'Personal care - ' . $faker->numberBetween(1, 10) . ' hours',
                                    'Medication administration',
                                    'Meal preparation service',
                                    'Night supervision',
                                    'Companionship visit',
                                ]),
                                'quantity' => $faker->randomFloat(1, 1, 10),
                                'unit_price' => $faker->randomFloat(2, 15, 50),
                                'tax' => $itemTax,
                                'discount' => 0,
                                'total' => $itemAmount,
                            ]
                        );
                    }
                }
            }
        }

        $this->command->info('Invoices seeded successfully.');
    }
}
