<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use function Sodium\crypto_box_publickey_from_secretkey;

class Favorite extends Model
{
	use RecordsActivity;

    protected $guarded = [];

	//Relations
    public function favorites()
	{
		return $this->morphTo();
	}
}

