<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidImageSizeUrl implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if headers can be retrieved
        $headers = @get_headers($value, 1);

        // Validate Content-Type header for image
        if ($headers['Content-Length'] <= 5242880) {
            return true;
        }

        return false;
    }
    public function message()
    {
        return 'Photo should be no more than 5 Mb.';
    }
}
