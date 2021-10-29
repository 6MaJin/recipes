<?php

namespace Tests\Unit;

use App\Models\Shoppinglist;
use App\Models\User;
use PhpParser\Node\Expr\Cast\Object_;
use Tests\TestCase;

class ShoppinglistTest extends TestCase
{
    protected $shoppinglist;

    protected function setUp(): void
    {
        $this->shoppinglist = new Shoppinglist();
    }

    /** @test */

    public function it_exists()
    {
        $this->assertInstanceOf(Shoppinglist::class, $this->shoppinglist);
    }

    public function it_has_name()
    {

    }

}
