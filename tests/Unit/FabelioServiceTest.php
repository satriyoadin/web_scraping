<?php

namespace Tests\Unit;

use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Facades\App\Http\Services\FabelioService as Fabelio;

class FabelioServiceTest extends TestCase
{
    public function test_it_throws_exception_on_empty_url()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('url cannot be empty!');

        $actual = Fabelio::getProductInfo('');
    }

    public function test_it_able_to_get_product_info()
    {
        $url = 'https://fabelio.com/ip/bran-2-seater-sofa.html';
        $expected = [
            'product_id' => '30055',
            'title' => 'Sofa 2 Dudukan Bran',
            'alt_title' => 'Bran 2 Seater Sofa',
            'price' => 1749000,
            'url' => $url
        ];

        $actual = Fabelio::getProductInfo($url);

        $this->assertArrayHasKey('product_id', $actual);
        $this->assertArrayHasKey('title', $actual);
        $this->assertArrayHasKey('alt_title', $actual);
        $this->assertArrayHasKey('description', $actual);
        $this->assertArrayHasKey('additional_info', $actual);
        $this->assertArrayHasKey('price', $actual);
        $this->assertArrayHasKey('url', $actual);
        $this->assertArrayHasKey('images', $actual);
        $this->assertArraySubset($expected, $actual);
    }

    public function test_it_throws_exception_on_empty_product_id()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('product id cannot be empty!');

        $actual = Fabelio::getPriceUpdate('');
    }

    public function test_it_able_to_get_price_update()
    {
        $productId = '30055';
        $expected = 1749000;

        $actual = Fabelio::getPriceUpdate($productId);

        $this->assertEquals($expected, $actual);
    }
}
