<?php


namespace App\Tests;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HttpApiTest extends ApiTestCase
{
    private $token;

    public function setUp()
    {
        $response = static::createClient()->request("POST", "/api/login_check", ['json' => [
            'Content-type' => 'application/json',
            "username" => "admin@reucopro.com",
            "password" => "admin",
        ]]);
        $this->token = json_decode($response->getContent(), true)['token'];
    }

    public function testPostLogin()
    {
        $response = static::createClient()->request("POST", "/api/login_check", ['json' => [
            'Content-type' => 'application/json',
            "username" => "admin@reucopro.com",
            "password" => "admin",
        ]]);
        $this->assertResponseIsSuccessful();
    }

    public function testGetBuildingsBySyndic(): void
    {
        $id = 0;
        try {
            $id = random_int(1, 4);
        } catch (\Exception $e) {
        }
        try {
            $response = static::createClient()->request('GET', "/api/syndics/{$id}/buildings", ['auth_bearer' => $this->token
            ]);
        } catch (TransportExceptionInterface $e) {
        }
        $this->assertResponseStatusCodeSame(200, "Wrong code, 200 expected");
    }

    public function testGetOwnersByBuilding(): void
    {
        $id = 0;
        $id2 = 0;
        try {
            $id = random_int(1, 100);
            $id2 = random_int(1, 100);
        } catch (\Exception $e) {
        }
        try {
            $response = static::createClient()->request('GET', "/api/syndics/{$id}/buildings/{$id2}/owners", ['auth_bearer' => $this->token]);
        } catch (TransportExceptionInterface $e) {
        }
        $this->assertResponseStatusCodeSame(200, "Wrong code, 200 expected");
    }

    public function testGetResolutionByMeeting(): void
    {
        $id = 0;
        try {
            $id = random_int(1, 100);
        } catch (\Exception $e) {
        }
        try {
            $response = static::createClient()->request('GET', "/api/meetings/{$id}/resolutions", ['auth_bearer' => $this->token]);
        } catch (TransportExceptionInterface $e) {
        }
        $this->assertResponseStatusCodeSame('200', "Wrong code, 200 expected");
    }

    public function testGetDelegationAll(): void
    {
        try {
            $response = static::createClient()->request('GET', '/api/delegations', ['auth_bearer' => $this->token]);
        } catch (TransportExceptionInterface $e) {
        }
        $this->assertResponseStatusCodeSame('200', 'Wrong code 200 expected');
    }

    public function testGetLotById(): void
    {
        $id = 0;
        try {
            $id = random_int(1, 100);
        } catch (\Exception $e) {
        }
        try {
            $response = static::createClient()->request('GET', "/api/lots/{$id}", ['auth_bearer' => $this->token]);
        } catch (TransportExceptionInterface $e) {
        }
        $this->assertResponseStatusCodeSame('200', 'Wrong code, 200 expected');
    }

    public function testGetUserAll(): void
    {
        try {
            $response = static::createClient()->request('GET', '/api/users', ['auth_bearer' => $this->token]);
        } catch (TransportExceptionInterface $e) {
        }
        $this->assertResponseStatusCodeSame('200', 'Wrong code, 200 expected');
    }

    public function testGetVoteById(): void
    {
        $id = 0;
        try {
            $id = random_int(1, 100);
        } catch (\Exception $e) {
        }
        try {
            $response = static::createClient()->request('GET', "/api/votes/{$id}", ['auth_bearer' => $this->token]);
        } catch (TransportExceptionInterface $e) {
        }
        $this->assertResponseStatusCodeSame('200', 'Wrong code, 200 expected');
    }

}