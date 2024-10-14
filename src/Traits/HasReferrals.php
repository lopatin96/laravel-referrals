<?php

namespace Atin\LaravelReferrals\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasReferrals
{
    /**
     * Generate a referral link for the user.
     */
    public function getReferralLink(): string
    {
        return route('register', ['ref' => $this->id]);
    }

    /**
     * Check if the user is a referral for another user.
     */
    public function isReferral(): bool
    {
        return ! is_null($this->referrer_id);
    }

    /**
     * Get the referrer for the user.
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id')
            ->withTrashed();
    }

    /**
     * Get all referrals for the user.
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(User::class, 'referrer_id');
    }

    /**
     * Get the total number of referrals for the user.
     */
    public function getTotalReferrals(): int
    {
        return $this->referrals()->count();
    }

    /**
     * Check if the user has any referrals.
     */
    public function hasReferrals(): bool
    {
        return $this->getTotalReferrals() > 0;
    }
}
