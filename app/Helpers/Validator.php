<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator as FacadesValidator;

class Validator {
    public static function validate($data, $rules) {
        $validator = FacadesValidator::make($data, $rules);

        return [
            'fails'=>$validator->fails(),
            'errors'=>$validator->errors()->all() ?: []
        ];
    }
}

