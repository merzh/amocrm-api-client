<?php


namespace Tests\AmoAPI;

use ddlzz\AmoAPI\CredentialsManager;
use PHPUnit\Framework\TestCase;

/**
 * Class CredentialsManagerTest
 * @package Tests\AmoAPI
 * @author ddlzz
 * @covers \ddlzz\AmoAPI\CredentialsManager
 * @covers \ddlzz\AmoAPI\Validators\CredentialsValidator
 */
final class CredentialsManagerTest extends TestCase
{
    /** @var CredentialsManager */
    private $credentialsManager;

    /** @var string */
    private $subdomain = 'test';

    /** @var string */
    private $login = 'testlogin@test.com';

    /** @var string */
    private $hash = 'b5b973a1dd4bf82c01180731acb8a615';

    protected function setUp()
    {
        $this->credentialsManager = new CredentialsManager($this->subdomain, $this->login, $this->hash);
    }

    public function testCreationFromValidParams()
    {
        $this::assertInstanceOf(CredentialsManager::class, new CredentialsManager($this->subdomain, $this->login, $this->hash));
    }

    /**
     * @expectedException \ddlzz\AmoAPI\Exceptions\InvalidArgumentException
     */
    public function testSubdomainValidation()
    {
        new CredentialsManager('some string', $this->login, $this->hash);
    }

    /**
     * @expectedException \ddlzz\AmoAPI\Exceptions\InvalidArgumentException
     */
    public function testLoginValidation()
    {
        new CredentialsManager($this->subdomain, 'test login', $this->hash);
    }

    /**
     * @expectedException \ddlzz\AmoAPI\Exceptions\InvalidArgumentException
     */
    public function testHashValidation()
    {
        new CredentialsManager($this->subdomain, $this->login, '@some $string!');
    }

    public function testGetSubdomain()
    {
        self::assertEquals($this->subdomain, $this->credentialsManager->getSubdomain());
    }
    
    public function testGetLogin()
    {
        self::assertEquals($this->login, $this->credentialsManager->getLogin());
    }

    public function testGetCredentials()
    {
        $expectedResult = ['USER_LOGIN' => $this->login, 'USER_HASH' => $this->hash];
        self::assertEquals($expectedResult, $this->credentialsManager->getCredentials());
    }
}