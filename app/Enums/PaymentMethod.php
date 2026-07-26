<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case BANK_TRANSFER = 'bank_transfer';
    case VIRTUAL_ACCOUNT = 'virtual_account';
    case QRIS = 'qris';
    case CREDIT_CARD = 'credit_card';
    case DEBIT_CARD = 'debit_card';
    case EWALLET = 'ewallet';

    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Cash (Manual)',
            self::BANK_TRANSFER => 'Bank Account Transfer',
            self::VIRTUAL_ACCOUNT => 'Virtual Account',
            self::QRIS => 'QRIS Code',
            self::CREDIT_CARD => 'Credit Card',
            self::DEBIT_CARD => 'Debit Card',
            self::EWALLET => 'E-Wallet',
        };
    }
}
