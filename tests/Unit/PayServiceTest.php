<?php

namespace Tests\Unit;

use App\Services\PayService;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class PayServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /*public function testMakeRequest()
    {
        $placetoService = App::make(PayService::class);
        $result=$placetoService->makeSession(['currency'=>'COP','total'=>'10000']);

        $this->assertArrayHasKey('code', $result);
        if ($result['code'] == 200) {
            $this->assertJson($result['data']);
        }
        $this->assertIsArray($result);
    }
*/
    /*  public function testCreateSession()
      {
          $placetoService = App::make(PayService::class);
          $buyer=new $buyer();
          $buyer->document='1040030020';
          $buyer->document_type='CC';
          $buyer->name='John';
          $buyer->surname='Doe';
          $buyer->email='johndoe@example.com';
          $buyer->movile='9865322645';
          $result=$placetoService->createSession($buyer,['currency'=>'COP','total'=>'10000']);
          $this->assertIsObject($result);

      }*/
  /*  public function testUpdatePaymentInfo()
    {

        $placetoService = App::make(PayService::class);
        $result = $placetoService->updatePaymentInfo();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('request', $result);


    }*/

    public function testListPayment()
    {

        $placetoService = App::make(PayService::class);
        $result = $placetoService->listPayment();
        $this->assertIsArray($result);



    }
}
