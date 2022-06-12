<?php
namespace App\Helpers;

use App\DubaiTwo;
use App\Three;
use App\Transaction;
use App\Two;
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
        $number = mt_rand(100000, 99999999);
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

    public static function batch(){
        $batch_id = 10;
        $exist = Two::orderBy('batch', 'desc')->pluck('batch')->first();

        if ($exist) {
            return ++$exist;
        }
        return $batch_id;
    }

    public static function DubaiBatch(){
        $batch_id = 10;
        $exist = DubaiTwo::orderBy('batch', 'desc')->pluck('batch')->first();

        if ($exist) {
            return ++$exist;
        }

        return $batch_id;
    }

    public static function ThreeBatch(){
        $batch_id = 10;
        $exist = Three::orderBy('batch', 'desc')->pluck('batch')->first();

        if ($exist) {
            return ++$exist;
        }

        return $batch_id;
    }
}
