<?php
namespace Edu\Cnm\DeepDiveOAuth\Test;

use Edu\Cnm\DeepDiveOAuth\Profile;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");
// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Tweet class
 *
 * This is a complete PHPUnit test of the Tweet class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Tweet
 * @author George Kephart <dmcdonald21@cnm.edu>
 **/

class ProfileTest extends DeepDiveOauthTest {

	protected $profileId = null;
	protected $profileImage = "flaksfdlkjflakffffdjdjdj";
	protected $profileUsername = "jfdjlsfjldkjfl";
	protected $profileOauthToken;

	public function setUp() {
	parent::setUp();

	$this->profileOauthToken = bin2hex(random_bytes(27));
	}

	public function testInsertValidProfile() {
		$numRows = $this->getConnection()->getRowCount("profile");


		$profileId = generateUuidV4();
		$profile = new Profile($profileId, "hello world", $this->profileOauthToken, "hello shity head");
		$profile->insert($this->getPDO());

		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profileId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
	$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileImage(), $profile->getProfileImage());
		$this->assertEquals($pdoProfile->getProfileOauthToken(), $profile->getProfileOauthToken());
		$this->assertEquals($pdoProfile->getProfileUsername(), $profile->getProfileUsername());
	}

	public function testGetProfileByOauthToken() {
		$numRows = $this->getConnection()->getRowCount("profile");


		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->profileImage, $this->profileOauthToken, $this->profileUsername);
		$profile->insert($this->getPDO());

		$pdoProfile = Profile::getProfileByProfileOauthToken($this->getPDO(), $profile->getProfileOauthToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileImage(), $profile->getProfileImage());
		$this->assertEquals($pdoProfile->getProfileOauthToken(), $profile->getProfileOauthToken());
		$this->assertEquals($pdoProfile->getProfileUsername(), $profile->getProfileUsername());
	}
	public function testGetProfileByProfileUsername() {
		$numRows = $this->getConnection()->getRowCount("profile");


		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->profileImage, $this->profileOauthToken, $this->profileUsername);
		$profile->insert($this->getPDO());

		$pdoProfile = Profile::getProfileByProfileUsername($this->getPDO(), $profile->getProfileUsername());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileImage(), $profile->getProfileImage());
		$this->assertEquals($pdoProfile->getProfileOauthToken(), $profile->getProfileOauthToken());
		$this->assertEquals($pdoProfile->getProfileUsername(), $profile->getProfileUsername());
	}
}