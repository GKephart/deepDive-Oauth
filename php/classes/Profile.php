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
			$this->setProfileUsername($newProfileUsername);

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

	/**
	 * accessor method for profileImage
	 * @return string profileImage
	 */
	public function getProfileImage() {
		return $this->profileImage;
	}

	/**
	 * mutator method for profile image
	 * @param string $newProfileImage
	 * @throws \InvalidArgumentException if $newProfileImage is not a string or is insecure
	 * @throws \RangeException if $newProfileImage > 128 characters
	 * @throws \TypeError if $newProfileImage is not a string
	 */
	public function setProfileImage($newProfileImage) {

		// verify the name is secure
		$newProfileImage = trim($newProfileImage);
		$newProfileImage = filter_var($newProfileImage, FILTER_SANITIZE_STRING);
		// make sure name is not empty
		if(empty($newProfileImage) === true) {
			throw(new \InvalidArgumentException("name is empty or insecure"));
		}

		// verify name will fit into database
		if(strlen($newProfileImage) > 128) {
			throw(new \RangeException("name is too long"));
		}
		// store profile name
		$this->profileImage = $newProfileImage;
	}

	/**
	 * accessor method for profile OAuth Token
	 * @return string $profileOauthToken the token used for the handshake with github
	 */
	public function getProfileOauthToken() {
		return $this->profileOauthToken;
	}

	/**
	 * mutator method for profile image
	 * @param string $newProfileOauthToken
	 * @throws \InvalidArgumentException if $newProfileOauthToken is not a string or is insecure
	 * @throws \RangeException if $newProfileOauthToken > 64 characters
	 * @throws \TypeError if $newProfileImage is not a string
	 */
	public function setProfileOauthToken($newProfileOauthToken) {

		// verify the name is secure
		$newProfileOauthToken = trim($newProfileOauthToken);
		$newProfileOauthToken = filter_var($newProfileOauthToken, FILTER_SANITIZE_STRING);
		// make sure name is not empty
		if(empty($newProfileOauthToken) === true) {
			throw(new \InvalidArgumentException("name is empty or insecure"));
		}
		// verify name will fit into database
		if(strlen($newProfileOauthToken) > 64) {
			throw(new \RangeException("name is too long"));
		}
		// store profile name
		$this->profileOauthToken = $newProfileOauthToken;
	}

	/**
	 * accessor method for Profile Username
	 * @return string $profileUserName the name of the user
	 */
	public function getProfileUsername() {
		return $this->profileUsername;
	}

	/**
	 * mutator method for profile username
	 * @param string $newProfileUsername
	 * @throws \InvalidArgumentException if $newProfileUsername is insecure
	 * @throws \RangeException if $newProfileUsername > 32 characters
	 * @throws \TypeError if $newProfile usernname is not a string
	 */
	public function setProfileUsername($newProfileUsername) {

		// verify the name is secure
		$newProfileUsername = trim($newProfileUsername);
		$newProfileUsername = filter_var($newProfileUsername, FILTER_SANITIZE_STRING);
		// make sure name is not empty
		if(empty($newProfileUsername ) === true) {
			throw(new \InvalidArgumentException("name is empty or insecure"));
		}
		// verify name will fit into database
		if(strlen($newProfileUsername) > 32) {
			throw(new \RangeException("name is too long"));
		}
		// store profile name
		$this->profileUsername = $newProfileUsername;
	}

	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// create query template

		$query = "INSERT INTO profile(profileId, profileImage, profileOauthToken, profileUsername) VALUES (:profileId, :profileImage, :profileOauthToken, :profileUsername)";
		$statement = $pdo->prepare($query);
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileImage" => $this->profileImage, "profileOauthToken" => $this->profileOauthToken, "profileUsername" => $this->profileUsername];
		//var_dump($parameters);
		$statement->execute($parameters);
	}

	/**
	 * gets the profile by profileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileId tweet id to search for
	 * @return Profile|null Tweet found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getProfileByProfileId(\PDO $pdo, string $profileId) : ?Profile {
		// sanitize the tweetId before searching
		try {
			$profileId = self::validateUuid($profileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT profileId, profileImage, profileOauthToken, profileUsername FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// bind the tweet id to the place holder in the template
		$parameters = ["profileId" => $profileId->getBytes()];
		$statement->execute($parameters);
		// grab the tweet from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileImage"], $row["profileOauthToken"], $row["profileUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}


	/**
	 * gets the profile by profileUsername
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileUsername tweet id to search for
	 * @return Profile|null Tweet found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getProfileByProfileUsername(\PDO $pdo, string $profileUsername) : ?Profile {
		// sanitize the description before searching
		$profileUsername = trim($profileUsername);
		$profileUsername = filter_var($profileUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileUsername) === true) {
			throw(new \PDOException("tweet content is invalid"));
		}
		// create query template
		$query = "SELECT profileId, profileImage, profileOauthToken, profileUsername FROM profile WHERE profileUsername = :profileUsername";
		$statement = $pdo->prepare($query);
		// bind the tweet id to the place holder in the template
		$parameters = ["profileUsername" => $profileUsername];
		$statement->execute($parameters);
		// grab the tweet from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileImage"], $row["profileOauthToken"], $row["profileUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}


	/**
	 * gets the profile by the profile Oauth token
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileOauthToken tweet id to search for
	 * @return Profile|null Tweet found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getProfileByProfileOauthToken(\PDO $pdo, string $profileOauthToken) : ?Profile {
		// sanitize the tweetId before searching
		// sanitize the description before searching
		$profileOauthToken = trim($profileOauthToken);
		$profileOauthToken = filter_var($profileOauthToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileOauthToken) === true) {
			throw(new \PDOException("tweet content is invalid"));
		}
		// create query template
		$query = "SELECT profileId, profileImage, profileOauthToken, profileUsername FROM profile WHERE profileOauthToken = :profileOauthToken";
		$statement = $pdo->prepare($query);
		// bind the tweet id to the place holder in the template
		$parameters = ["profileOauthToken" => $profileOauthToken];
		$statement->execute($parameters);
		// grab the tweet from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileImage"], $row["profileOauthToken"], $row["profileUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}


	/**
	 * format the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["profileId"] = $this->profileId->toString();
	}
}