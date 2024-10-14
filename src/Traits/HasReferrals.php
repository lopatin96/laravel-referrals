<?php

namespace Atin\LaravelReferrals\Traits;

trait HasReferrals
{
    public function getReferralLink(): string
    {
        return route('register', ['ref' => $this->id]);
    }
}