<?php

namespace Shumonpal\ProjectSecurity\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Account
 * @package Shumonpal\ProjectSecurity\Models
 * @version January 8, 2024, 2:57 pm UTC
 *
 * @property string $code
 * @property string $domain
 * @property boolean $status
 */

class ShumonpalLicence extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        'code', 'domain', 'created_at'
    ];
}
