<?php

namespace App\Rules;

use App\Models\Casino;
use Illuminate\Contracts\Validation\Rule;

class ListingRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $listingIds = array_unique($value);
        $counts = Casino::whereIn('id', $listingIds)->count();

        return $counts === count($listingIds);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'One or more casino Id is Invalid';
    }
}
