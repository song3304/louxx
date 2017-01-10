<?php
namespace App;

use OwenIt\Auditing\Auditable;

trait Logable
{
	use Auditable;

	/**
     * Init auditing.
     */
    public static function bootLogable()
    {

    }

    /**
     * Get the entity's audits.
     */
    public function audits()
    {
        return $this->morphMany(Log::class, 'auditable');
    }

	/**
     * Get the entity's logs.
     */
    public function logs()
    {
        return $this->morphMany(Log::class, 'auditable');
    }
}