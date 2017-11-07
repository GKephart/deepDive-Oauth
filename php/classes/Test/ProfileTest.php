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

	$this->profileOauthToken = bin2hex(random_bytes(48));
	}
}