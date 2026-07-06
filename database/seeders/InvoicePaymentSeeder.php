<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoicePayment;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class InvoicePaymentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $paidInvoices = Invoice::whereIn('status', ['paid', 'partially_paid'])->get();

        foreach ($paidInvoices as $invoice) {
            InvoicePayment::firstOrCreate(
                ['invoice_id' => $invoice->id, 'reference' => 'PAY-' . $invoice->invoice_number],
                [
                    'uuid' => \Illuminate\Support\Str::uuid(),
                    'amount' => $invoice->total,
                    'payment_date' => $invoice->paid_date ?? now()->subDays(rand(1, 10))->format('Y-m-d'),
                    'payment_method' => $faker->randomElement(['bank_transfer', 'card', 'cheque', 'direct_debit']),
                    'reference' => 'PAY-' . $invoice->invoice_number,
                    'status' => 'completed',
                ]
            );
        }

        $this->command->info('Invoice payments seeded successfully.');
    }
}
