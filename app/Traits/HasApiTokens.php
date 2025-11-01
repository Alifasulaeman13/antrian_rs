<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait HasApiTokens
{
    /**
     * The current token being used by the user.
     */
    protected $accessToken;

    /**
     * Create a new personal access token for the user.
     *
     * @param  string  $name
     * @param  array  $abilities
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createToken(string $name, array $abilities = ['*'])
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
        ]);

        return new \App\Models\PersonalAccessToken([
            'accessToken' => $token,
            'plainTextToken' => $plainTextToken,
        ]);
    }

    /**
     * Get the tokens that belong to model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tokens()
    {
        return $this->morphMany(\App\Models\PersonalAccessToken::class, 'tokenable');
    }

    /**
     * Determine if the current API token has a given ability.
     *
     * @param  string  $ability
     * @return bool
     */
    public function tokenCan(string $ability)
    {
        return $this->accessToken ? in_array('*', $this->accessToken->abilities) ||
               in_array($ability, $this->accessToken->abilities) : false;
    }

    /**
     * Get the access token currently associated with the user.
     *
     * @return \App\Models\PersonalAccessToken
     */
    public function currentAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set the current access token for the user.
     *
     * @param  \App\Models\PersonalAccessToken  $accessToken
     * @return $this
     */
    public function withAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }
}