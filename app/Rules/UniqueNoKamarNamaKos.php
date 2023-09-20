<?php

namespace App\Rules;

use App\Models\Kamar;
use App\Models\Penyewa;
use Illuminate\Contracts\Validation\Rule;

class UniqueNoKamarNamaKos implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $lokasiId;

    public function __construct($lokasiId)
    {
        $this->lokasiId = $lokasiId;
    }

    public function passes($attribute, $value)
    {
        // Check if a Kamar with the same 'no_kamar' or 'kamar_id' exists in the same 'lokasi_id'
        return Kamar::where(function ($query) use ($value) {
            $query->where('no_kamar', $value)->orWhere('id', $value);
        })->where('kost_id', $this->lokasiId)->exists();
    }

    public function message()
    {
        return 'The selected :attribute is not associated with the specified nama kos.';
    }
}
