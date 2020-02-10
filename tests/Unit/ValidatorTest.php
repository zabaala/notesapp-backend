<?php

namespace Tests\Unit;

use \App\Support\Validation\Test\SampleValidation;

use App\Support\Validation\ValidationException;
use Tests\TestCase;

class ValidatorTest extends TestCase
{
    /**
     * @throws ValidationException
     */
    public function testValidation()
    {
        $this->expectException(\App\Support\Validation\ValidationException::class);
        $validation = (new SampleValidation([]))->validate();
    }

    public function test_surround_validation_exception_with_try_catch()
    {
        try {
            $validation = (new SampleValidation([]))->validate();
        } catch (ValidationException $e) {
            $this->assertEquals(2, $e->count());
            $this->assertIsArray($e->get('first_name'));
            $this->assertEquals(
                '[custom]: The first name field is required.',
                $e->get('first_name')[0]
            );
        }
    }

    /**
     * @throws ValidationException
     */
    public function test_success()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
        ];

        $validation = (new SampleValidation($data))->validate();
        $this->assertTrue($validation);
    }
}
