<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Bank;
use App\Models\CreditCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EncryptionResilienceTest extends TestCase
{
    use RefreshDatabase;

    public function test_credit_card_encrypts_and_decrypts_valid_numbers(): void
    {
        $user = User::factory()->create();
        $bank = Bank::create(['name' => 'Garanti', 'is_system' => true]);

        $card = CreditCard::create([
            'user_id' => $user->id,
            'bank_id' => $bank->id,
            'name' => 'Bonus Kart',
            'card_number' => '5400123456789012',
            'last_four' => '9012',
            'credit_limit' => 50000,
            'current_debt' => 12000,
        ]);

        $this->assertEquals('5400123456789012', $card->card_number);
        $this->assertEquals('5400 1234 5678 9012', $card->formatted_card_number);
        $this->assertEquals('•••• •••• •••• 9012', $card->masked_card_number);
    }

    public function test_credit_card_does_not_throw_on_corrupted_mac_or_key_change(): void
    {
        $user = User::factory()->create();
        $bank = Bank::create(['name' => 'Garanti', 'is_system' => true]);

        // Simulate a corrupted or mismatched APP_KEY payload directly in the database
        $card = new CreditCard([
            'user_id' => $user->id,
            'bank_id' => $bank->id,
            'name' => 'Bonus Kart',
            'last_four' => '4589',
            'credit_limit' => 50000,
            'current_debt' => 12000,
        ]);
        $card->setRawAttributes(array_merge($card->getAttributes(), [
            'card_number' => 'eyJpdiI6IjcyeHg9PSIsInZhbHVlIjoiY29ycnVwdGVkIiwibWFjIjoiZmFrZW1hYzEyMyJ9',
        ]));
        $card->save();

        // Must not throw DecryptException!
        $this->assertNull($card->card_number);
        $this->assertEquals('•••• •••• •••• 4589', $card->masked_card_number);
        $this->assertEquals('•••• •••• •••• 4589', $card->formatted_card_number);
    }

    public function test_account_does_not_throw_on_corrupted_mac_or_key_change(): void
    {
        $user = User::factory()->create();
        $bank = Bank::create(['name' => 'Garanti', 'is_system' => true]);

        $account = new Account([
            'user_id' => $user->id,
            'bank_id' => $bank->id,
            'name' => 'Vadesiz TL',
            'type' => 'checking',
            'balance' => 5000,
        ]);
        $account->setRawAttributes(array_merge($account->getAttributes(), [
            'iban' => 'eyJpdiI6IjcyeHg9PSIsInZhbHVlIjoiY29ycnVwdGVkIiwibWFjIjoiZmFrZW1hYzEyMyJ9',
        ]));
        $account->save();

        // Must not throw DecryptException!
        $this->assertNull($account->iban);
        $this->assertEquals('-', $account->masked_iban);
        $this->assertEquals('-', $account->formatted_iban);
    }
}
