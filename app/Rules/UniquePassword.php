<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UniquePassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string = null): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // ambil data user saat ini
        $user = Auth::user();

        // cek apakah password baru berbeda dengan password lama
        if (Hash::check($value, $user->password)) {
            $fail('Kata sandi tidak boleh sama dengan password lama');
        }
    }
}
