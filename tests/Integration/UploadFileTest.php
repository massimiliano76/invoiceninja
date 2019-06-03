<?php

namespace Tests\Integration;

use App\Events\Invoice\InvoiceWasCreated;
use App\Events\Invoice\InvoiceWasUpdated;
use App\Events\Payment\PaymentWasCreated;
use App\Jobs\Invoice\MarkInvoicePaid;
use App\Jobs\Util\UploadFile;
use App\Models\Account;
use App\Models\Activity;
use App\Models\Company;
use App\Models\CompanyLedger;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Tests\MockAccountData;
use Tests\TestCase;

/**
 * @test
 * @covers  App\Jobs\Util\UploadFile
 */
class UploadFileTest extends TestCase
{
    use MockAccountData;
    use DatabaseTransactions;

    public function setUp() :void
    {
        parent::setUp();

        $this->makeTestData();
    }


    public function testFileUploadWorks()
    {

        $document = UploadFile::dispatchNow(UploadedFile::fake()->image('avatar.jpg'), $this->invoice->user, $this->invoice->company, $this->invoice);

        $this->assertNotNull($document);
        
Log::error($document);
//        $this->assertEquals($invoice->amount, $payment);

    }



}