<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentGateway extends Model
{
    /*** _____________________________________________ use SECTION ________________________________________________ ***/
    use HasFactory;
    use SoftDeletes;

    /*** _____________________________________________ props SECTION ______________________________________________ ***/
    protected $fillable = [
        'gateway',
        'owner',
        'config',
        'status',
        'sort_order',
    ];

    /*** _____________________________________________ model related methods SECTION ______________________________ ***/

    protected function casts(): array
    {
        return [
            'config' => 'array',
            'status' => 'bool',
//        'gateway' => \App\Enums\PaymentGateways::class,
        ];
    }

    #[Scope]
    public function active(): Builder
    {
        return $this->where('status', true);
    }

    /*** _____________________________________________ relations SECTION __________________________________________ ***/

    /*** _____________________________________________ method SECTION __________________________________________ ***/
}
