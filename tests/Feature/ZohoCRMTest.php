<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ZohoCRMTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_GetAccounts(): void
    {
        $response = $this->get('/api/account');

        $response->assertStatus(200);
        $data = $response->json();

        $response = $this->get('/api/deals/get-by-account-id/' . $data[0]['id']);
        $response->assertStatus(200);
    }

    public function test_GetDeals(): void
    {
        $response = $this->get('/api/deal');

        $response->assertStatus(200);
        $data = $response->json();
        $response = $this->get('/api/deal/' . $data[0]['id']);

        $response->assertStatus(200);
    }

    public function test_CreateAccount(): void
    {
        // Генерація фейкових даних
        $faker = \Faker\Factory::create();

        $fakeName = $faker->name;
        $fakeWebsite = $faker->url;
        $fakePhone = '+380' . rand(100000000, 999999999);

        // Вивід фейкових даних для перевірки
        $this->assertNotEmpty($fakeName);
        $this->assertNotEmpty($fakeWebsite);

        // Додатково: можна використовувати ці дані для тестування API або моделей
        $response = $this->post('/api/account', [
            'Account_Name' => $fakeName,
            'Website' => $fakeWebsite,
            'Phone' => $fakePhone,
        ]);

        $response->assertStatus(200); // Перевірка успішного створення
    }

    public function test_CreateDeal(): void
    {
        $response = $this->get('/api/account');

        $response->assertStatus(200);
        $accounts = $response->json();

        // Генерація фейкових даних
        $faker = \Faker\Factory::create();

        $fakeName = $faker->name;
        $stage = $faker->text(20);

        // Вивід фейкових даних для перевірки
        $this->assertNotEmpty($fakeName);
        $this->assertNotEmpty($stage);
        $this->assertLessThanOrEqual(20, strlen($stage));

        // Додатково: можна використовувати ці дані для тестування API або моделей
        $response = $this->post('/api/deal', [
            'Deal_Name' => $fakeName,
            'Stage' => $stage,
            'Account_Name' => [
                'id' => $accounts[0]['id'],
            ],
        ]);

        $response->assertStatus(200); // Перевірка успішного створення
    }

    public function test_UpdateDeal(): void
    {
        $response = $this->get('/api/account');
        $response->assertStatus(200);
        $accounts = $response->json();

        $response = $this->get('/api/deal');
        $response->assertStatus(200);
        $deals = $response->json();

        // Генерація фейкових даних
        $faker = \Faker\Factory::create();

        $fakeName = $faker->name;
        $stage = $faker->text(20);

        // Вивід фейкових даних для перевірки
        $this->assertNotEmpty($fakeName);
        $this->assertNotEmpty($stage);
        $this->assertLessThanOrEqual(20, strlen($stage));

        // Додатково: можна використовувати ці дані для тестування API або моделей
        $response = $this->patch('/api/deal/' . $deals[0]['id'], [
            'Deal_Name' => $fakeName,
            'Stage' => $stage,
            'Account_Name' => [
                'id' => $accounts[0]['id'],
            ],
        ]);

        $response->assertStatus(200); // Перевірка успішного створення
    }
}
