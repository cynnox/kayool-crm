<?php

namespace Webkul\Email\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Email\Contracts\EmailInboxTrackJob as EmailInboxTrackJobContract;

class EmailInboxTrackJob extends Model implements EmailInboxTrackJobContract
{
    protected $table = 'email_inbox_track_job';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_checked_date',
    ];
}
