<?php

namespace App\Helpers;

use App\ShowHide;

class ForShowHideStatus
{
    public static function Status($status){
        $form = ShowHide::where('name', $status)->first();

        if ($form->status == 'show') {
            $form->update([
                'status' => 'hide'
            ]);
        } else {
            $form->update([
                'status' => 'show'
            ]);
        }

    }
}
