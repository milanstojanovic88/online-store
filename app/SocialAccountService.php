<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
	/**
	 * @param ProviderUser $providerUser
	 * @param $provider
	 *
	 * @return User
	 */
	public function createOrGetUser(ProviderUser $providerUser, $provider)
	{
		$account = SocialAccount::where('provider', '=', $provider)
		                        ->where('provider_user_id', '=', $providerUser->getId())
		                        ->first();

		if ($account) {
			return $account->user;
		} else {

			$account = new SocialAccount([
				'provider_user_id' => $providerUser->getId(),
				'provider' => $provider
			]);

			$user = User::where('email', '=', $providerUser->getEmail())->first();

			if (!$user) {

				$user = new User([
					'email' => $providerUser->getEmail(),
					'name' => $providerUser->getName(),
				]);

				$user->save();
			}

			$account->user()->associate($user);
			$account->save();

			return $user;

		}

	}
}