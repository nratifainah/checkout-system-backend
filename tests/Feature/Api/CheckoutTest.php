<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CheckoutTest extends TestCase
{


    use DatabaseTransactions;

    private $header = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    ];

    private $checkoutService;

    CONST NORMAL_PRICE_CLASSIC = 269.99;
    CONST NORMAL_PRICE_STANDOUT = 322.99;
    CONST NORMAL_PRICE_PREMIUM= 394.99;


    const PROMO_PRICE_STANDOUT_NIKE =  299.99;
    const PROMO_PRICE_PREMIUM_FORD =  389.99;

    public function setUp() {

        parent::setUp();

        $this->checkoutService = $this->app->make('App\Services\CheckoutService');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }


    /**
     * Test checkout without login
     */
    public function testNotAuthorize(){
        $response = $this->json('POST', '/api/checkout');

        $response
            ->assertStatus(401);
    }


    /**
     * Test checkout with invalid request
     */
    public function testBadRequest(){
        $this->mockUser('ordinary@mail.com');

        $response = $this->json('POST', '/api/checkout', []);

        $response
            ->assertStatus(422);
    }



    /**
     * Test checkout with classic product for normal customer(no offer)
     */
    public function testClassicNormalCustomerCheckout(){
        $this->mockUser('ordinary@mail.com');

        $quantity = 5;
        $body = [
            "products" => [
                0  => [
                    "product_id"    => 1,
                    "quantity"      => $quantity
                ]
            ]
        ];

        $user = User::where('email', 'ordinary@mail.com')->first();
        $response = $this->actingAs($user)->json(
            'POST',
            '/api/checkout',
            $body,
            $this->header
        );


        $actualPrice = $this->checkoutService->calculatePrice($quantity, self::NORMAL_PRICE_CLASSIC);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "success"
            ])
            ->assertJsonStructure(['data'])
            ->assertJsonFragment(['total_price' => $actualPrice]);
    }


    /**
     * Test checkout for normal customer(no offer) with classic, stand out and premium
     */
    public function testNormalCustomerCheckout(){
        $this->mockUser('ordinary@mail.com');
        $quantity = 1;

        $body = [
            "products" => [
                0  => [
                    "product_id"    => 1,
                    "quantity"      => $quantity
                ],
                1  => [
                    "product_id"    => 2,
                    "quantity"      => $quantity
                ],
                2  => [
                    "product_id"    => 3,
                    "quantity"      => $quantity
                ]
            ]
        ];

        $user = User::where('email', 'ordinary@mail.com')->first();
        $response = $this->actingAs($user)->json(
            'POST',
            '/api/checkout',
            $body,
            $this->header
        );


        $actualPrice = self::NORMAL_PRICE_CLASSIC + self::NORMAL_PRICE_STANDOUT + self::NORMAL_PRICE_PREMIUM;

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "success"
            ])
            ->assertJsonStructure(['data'])
            ->assertJsonFragment(['total_price' => $actualPrice]);
    }


    /**
     * Test checkout for  customer having offer with classic package
     */
    public function testClassicOfferCustomerCheckout(){

        $this->mockUser('unilever@mail.com');
        $quantity = 3;
        $body = [
            "products" => [
                0  => [
                    "product_id"    => 1,
                    "quantity"      => $quantity
                ]
            ]
        ];

        $response = $this->json(
            'POST',
            '/api/checkout',
            $body,
            $this->header
        );

        $actualPrice = 2 * self::NORMAL_PRICE_CLASSIC;

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "success"
            ])
            ->assertJsonStructure(['data'])
            ->assertJsonFragment(['total_price' => $actualPrice]);
    }


    /**
     * Test checkout for  customer having offer with standout package
     */
    public function testStandoutOfferCustomerCheckout(){

        $this->mockUser('apple@mail.com');

        $quantity = 3;
        $body = [
            "products" => [
                0  => [
                    "product_id"    => 2,
                    "quantity"      => $quantity
                ]
            ]
        ];


        $response = $this->json(
            'POST',
            '/api/checkout',
            $body,
            $this->header
        );

        $actualPrice = $quantity * self::PROMO_PRICE_STANDOUT_NIKE;

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "success"
            ])
            ->assertJsonStructure(['data'])
            ->assertJsonFragment(['total_price' => $actualPrice]);
    }

    /**
     * Test checkout for  customer having offer with standout package
     */
    public function testClassicAndPremiumOfferCustomerCheckout(){

        $this->mockUser('ford@mail.com');

        $classicQuantity = 5;
        $premiumQuantity = 3;
        $body = [
            "products" => [
                1  => [
                    "product_id"    => 1,
                    "quantity"      => $classicQuantity
                ],
                2  => [
                    "product_id"    => 3,
                    "quantity"      => $premiumQuantity
                ]
            ]
        ];


        $response = $this->json(
            'POST',
            '/api/checkout',
            $body,
            $this->header
        );

        $actualPrice = (($classicQuantity - 1) * self::NORMAL_PRICE_CLASSIC) + $premiumQuantity * self::PROMO_PRICE_PREMIUM_FORD;

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "success"
            ])
            ->assertJsonStructure(['data'])
            ->assertJsonFragment(['total_price' => $actualPrice]);
    }


    public function mockUser($email){

        $user = User::where('email', $email)->first();
        Passport::actingAs($user);

    }
}
