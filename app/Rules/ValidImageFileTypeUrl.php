<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;

class ValidImageFileTypeUrl implements Rule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes($attribute, $value)
    {
        // Check if headers can be retrieved
        $headers = @get_headers($value, 1);

        // Validate Content-Type header for image
        if (
            $headers['Content-Type'] == 'image/png' ||
            $headers['Content-Type'] == 'image/jpg' ||
            $headers['Content-Type'] == 'image/jpeg'
        ) {
            $contentType = is_array($headers['Content-Type']) ? $headers['Content-Type'][0] : $headers['Content-Type'];
            return str_starts_with($contentType, 'image/');
        }

        return false;
    }
    public function message()
    {
        return 'Photo must be in a valid image format (jpg, png, jpeg).';
    }
}
