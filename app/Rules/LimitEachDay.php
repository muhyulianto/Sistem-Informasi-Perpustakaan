<?php

namespace App\Rules;
use App\Peminjaman;

use Illuminate\Contracts\Validation\Rule;

class LimitEachDay implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        Peminjaman::where('tanggal_pinjam', $value)->count() == 3;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Anda hanya dapat meminjam 3 buku dalam sehari.';
    }
}
