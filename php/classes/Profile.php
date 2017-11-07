<?php

namespace Edu\Cnm\DeepDiveOAuth;

use Ramsey\Uuid\Uuid;

require_once("autoload.php");

/**
 * class for the Profile
 *
 * this is the class that will be used to implement Oauth2 with github
 *
 * @author George Kephart <gkephart@cnm.edu>
 */

class Profile implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * Id of this profile I.E the primary key
	 * @var Uuid $profileId
	 **/
	private $profileId;

	/**
	 * path to the users avatar stored on github\
	 * @var string $profileImage
	 */
	private $profileImage;

	/**
	 * Oauth token used to have github verify login
	 * string $profileOauthToken
	 */
	private $profileOauthToken;

	/**
	 * username that will be stolen from information available via the Oauth handshake
	 * string $profileUsername
	 **/
	private $profileUsername;


	public function jsonSerialize() {
		// TODO: Implement jsonSerialize() method.
	}
}