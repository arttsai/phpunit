<?php
namespace Acme\Test;

use Acme\Http\Request;
use Acme\Http\Response;
use Acme\Validation\Validator;

/**
 *
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
  protected $request;
  protected $response;
  protected $validator;
  protected $testdata;

    protected function setUpRequestResponse()
    {
      if ($this->testdata == null)
        $this->testdata = [];

      $this->request = new Request($this->testdata  );
      $this->response = new Response($this->request);
      $this->validator = new Validator($this->request, $this->response);
    }


    public function testGetIsValidReturnsTrue()
    {
      $this->setUpRequestResponse();

      $this->validator->setIsValid(true);
      $this->assertTrue($this->validator->getIsValid());
    }

    public function testGetIsValidReturnsFalse()
    {
      $this->setUpRequestResponse();

      $this->validator->setIsValid(false);
      $this->assertFalse($this->validator->getIsValid());
    }

    public function testCheckForMinStringLengthWithValidData()
    {
      $this->testdata = ['mintype' => 'yellow'];
      $this->setUpRequestResponse();

      $errors = $this->validator->check(['mintype' => 'min:3']);
      $this->assertCount(0, $errors);
    }

    public function testCheckForMinStringLengthWithInvalidData()
    {
      $this->testdata = ['mintype' => 'yw'];
      $this->setUpRequestResponse();

      $errors = $this->validator->check(['mintype' => 'min:3']);
      $this->assertCount(1, $errors);
    }

    public function testCheckForEmailWithValidData($value='')
    {
      $this->testdata = ['mintype' => 'yw@here.com'];
      $this->setUpRequestResponse();

      $errors = $this->validator->check(['mintype' => 'email']);
      $this->assertCount(0, $errors);
    }

    public function testValidateWithInvalidData()
    {
      $this->testdata = ['check_field' => 'x'];
      $this->setUpRequestResponse();
      $this->validator->validate('check_field' => 'email', '/register'); 
    }

}
