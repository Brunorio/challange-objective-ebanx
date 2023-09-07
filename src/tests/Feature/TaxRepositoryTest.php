<?php 
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaxRepositoryTest extends TestCase {
  
  use RefreshDatabase;

  public function testShouldCreateTax(){
    $taxRepository = new \Repository\Tax();
    $tax = new \Tax("D", "Debit", 100);
    $taxRepository->create($tax);

    $taxModel = \App\Models\Tax::where('id', $tax->getId())->first();
    $this->assertEquals($taxModel->id, $tax->getId());
    $this->assertEquals($taxModel->name, $tax->getName());
    $this->assertEquals($taxModel->tax, $tax->getTax());
  }

  public function testShouldThrowExceptionWhenCreateRepetTaxId(){
    $taxRepository = new \Repository\Tax();
    $tax = new \Tax("A", "PaymentA", 100);
    $taxRepository->create($tax);

    $this->expectException(\Exception::class);
    $tax = new \Tax("A", "PaymentA", 100);
    $taxRepository->create($tax);
  }

  public function testShouldUpdateTax(){
    $taxRepository = new \Repository\Tax();
    $tax = new \Tax("C", "Credit", 100);
    $taxRepository->create($tax);

    $taxModel = \App\Models\Tax::where('id', $tax->getId())->first();
    $this->assertEquals($taxModel->id, $tax->getId());
    $this->assertEquals($taxModel->name, $tax->getName());
    $this->assertEquals($taxModel->tax, $tax->getTax());
  }

  public function testShouldFindTax(){
    $taxRepository = new \Repository\Tax();
    $tax = new \Tax("P", "Pix", 100);
    $taxRepository->create($tax);

    $taxModel = \App\Models\Tax::where('id', $tax->getId())->first();

    $taxFounded = $taxRepository->find($tax->getId());
    $this->assertEquals($taxModel->id, $taxFounded->getId());
    $this->assertEquals($taxModel->name, $taxFounded->getName());
    $this->assertEquals($taxModel->tax, $taxFounded->getTax());
  }
 

}