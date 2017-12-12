<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    //
    /**
     * status pending.
     */
    const PENDDING = 0;

    /**
     * status accepted.
     */
    const ACCEPTED = 1;

    /**
     * status canceled.
     */
    const CANCELED = 2;
}
