<?php
namespace App\Helpers;

use App\Transaction;
use App\Wallet;

class UUIDGenerator
{
    public static function AccountNumber()
    {
        $number = mt_rand(100000000, 999999999);
        $exist = Wallet::where('account_numbers', $number)->exists();
        if ($exist) {
            self::AccountNumber();
        }
        return $number;
    }

    public static function RefNumber()
    {
        $number = mt_rand(100000000, 999999999);
        $exist = Transaction::where('ref_no', $number)->exists();
        if ($exist) {
            self::RefNumber();
        }
        return $number;
    }

    public static function TrxId()
    {
        $number = mt_rand(100000000, 999999999);
        $exist = Transaction::where('trx_id', $number)->exists();
        if ($exist) {
            self::TrxId();
        }
        return $number;
    }
}
