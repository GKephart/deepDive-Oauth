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

	/**
	 * @param string | Uuid $newProfileId primary key for the Profile Object
	 * @param string $newProfileImage path to the users avatar stored on github\
	 * @param string $newProfileOauthToken token for Oauth handshake
	 * @param string $newProfileUsername name of the user
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 * @see https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct($newProfileId, string $newProfileImage, string $newProfileOauthToken, string $newProfileUsername) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileImage($newProfileImage);
			$this->setProfileOauthToken($newProfileOauthToken);
			$this->setProfileImage($newProfileUsername);

		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value of profile id (or null if new Profile)
	 **/
	public function getProfileId(): Uuid {
		return ($this->profileId);
	}
	/**
	 * mutator method for profile id
	 *
	 * @param  Uuid| string $newProfileId value of new profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if the profile Id is not
	 **/
	public function setProfileId( $newProfileId): void {
		try {
			$uuid = self::validateUuid($newProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->profileId = $uuid;
	}





	public function jsonSerialize() {
		// TODO: Implement jsonSerialize() method.
	}
}