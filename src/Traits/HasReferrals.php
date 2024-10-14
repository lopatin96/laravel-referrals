<?php

namespace Atin\LaravelReferrals\Traits;

use App\Models\User;

trait HasReferrals
{
    /**
     * Generate a referral link for the user.
     *
     * @return string
     */
    public function getReferralLink(): string
    {
        return route('register', ['ref' => $this->id]);
    }

    /**
     * Check if the user is a referral for another user.
     *
     * @return bool
     */
    public function isReferral(): bool
    {
        return ! is_null($this->referrer_id);
    }

    /**
     * Get the referrer for the user.
     *
     * @return User|null
     */
    public function getReferrer(): ?User
    {
        return $this->referrer_id ? User::find($this->referrer_id) : null;
    }

    /**
     * Get all referrals for the user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getReferrals()
    {
        return User::where('referrer_id', $this->id)->get();
    }

    /**
     * Get the total number of referrals for the user.
     *
     * @return int
     */
    public function getTotalReferrals(): int
    {
        return $this->getReferrals()->count();
    }

    /**
     * Check if the user has any referrals.
     *
     * @return bool
     */
    public function hasReferrals(): bool
    {
        return $this->getTotalReferrals() > 0;
    }
}