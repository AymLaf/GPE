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

    public function testGetBuildingsInSyndic(): void
    {
        $res = static::createClient()->request("POST", "/api/login_check", ['json' => [
            'Content-type' => 'application/json',
            "username" => "admin@reucopro.com",
            "password" => "admin",
        ]]);

//        $token = json_decode($res->getContent(), true)['token'];
//        var_dump($token);
        try {
            $response = static::createClient()->request('GET', '/api/syndics/1/buildings', ['auth_bearer' => $this->token
            ]);
        } catch (TransportExceptionInterface $e) {
        }
        $this->assertResponseStatusCodeSame(200, "Wrong code, 200 expected");
    }

}