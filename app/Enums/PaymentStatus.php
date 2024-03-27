<?php

namespace App\Enums;
use App\Traits\EnumFromName;

enum PaymentStatus: int
{
    use EnumFromName;

    case ABANDONED = 8;
    case FAILED = 2;
    case ONGOING = 3;
    case PENDING = 4;
    case PROCESSING = 5;
    case QUEUED = 6;
    case REVERSED = 7;
    case SUCCESS = 1;

    public function description(): string
    {
        return match ($this) {
            self::ABANDONED => "The customer has not completed the transaction.",
            self::FAILED => "The transaction failed. For more information on why, refer to the message/gateway response.",
            self::ONGOING => "The customer is currently trying to carry out an action to complete the transaction.
                This can get returned when we're waiting on the customer to enter an otp or to make a transfer (for a pay with transfer transaction).",
            self::PENDING => "The transaction is currently in progress.",
            self::PROCESSING => "Same as pending, but for direct debit transactions.",
            self::QUEUED => "The transaction has been queued to be processed later. Only possible on bulk charge transactions.",
            self::REVERSED => "The transaction was reversed. This could mean the transaction was refunded,
                or a chargeback was successfully logged for this transaction.",
            self::SUCCESS => "The transaction was successfully processed."
        };
    }
}
