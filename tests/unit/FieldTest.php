<?php

use ThisVessel\Caravel\Field;

class FieldTest extends PHPUnit_Framework_TestCase
{
    public function newField($options = null)
    {
        return new Field('my_field', 'input', $options);
    }

    public function testConstructorTypeStringDefaultsToInput()
    {
        $field = new Field('my_field', 'anything');

        $this->assertEquals($field->type, 'input');
    }

    public function testConstructorTypeDbalTextType()
    {
        $textType = \Doctrine\DBAL\Types\Type::getType('text');
        $field = new Field('my_field', $textType);

        $this->assertEquals($field->type, 'textarea');
    }

    public function testObjectToString()
    {
        $field = $this->newField();

        $this->assertEquals(strval($field), 'my_field');
    }

    public function testFieldDefaults()
    {
        $field = $this->newField();

        $this->assertEquals($field->name, 'my_field');
        $this->assertEquals($field->label, 'My Field');
        $this->assertEquals($field->type, 'input');
        $this->assertEquals($field->listable, true);
        $this->assertEquals($field->required, false);
        $this->assertEquals($field->help, null);
        $this->assertEquals($field->modifiers, null);
        $this->assertEquals($field->rules, null);
    }

    public function testOptionsStringProperlySeparatingModifiersFromRules()
    {
        $options = 'required|unlist|type:file|min:8';
        $field = $this->newField($options);

        $this->assertEquals($field->required, true);
        $this->assertEquals($field->listable, false);
        $this->assertEquals($field->type, 'file');
        $this->assertEquals($field->rules, 'required|min:8');
        $this->assertEquals($field->modifiers, 'unlist|type:file');
    }

    public function testType()
    {
        $options = 'required|type:file|min:8';
        $field1 = $this->newField($options);

        $options = [
            'type' => 'file',
            'rules' => 'required|min:8',
        ];
        $field2 = $this->newField($options);

        $this->assertEquals($field1->type, 'file');
        $this->assertEquals($field2->type, 'file');
    }

    public function testRequired()
    {
        $options = 'required|type:file|min:8';
        $field1 = $this->newField($options);

        $options = [
            'type' => 'file',
            'rules' => 'required|min:8',
        ];
        $field2 = $this->newField($options);

        $this->assertEquals($field1->required, true);
        $this->assertEquals($field2->required, true);
    }

    public function testUnlist()
    {
        $options = 'required|unlist|type:file|min:8';
        $field1 = $this->newField($options);

        $options = [
            'type' => 'file',
            'rules' => 'required|min:8',
            'modifiers' => 'unlist|lol',
        ];
        $field2 = $this->newField($options);

        $this->assertEquals($field1->listable, false);
        $this->assertEquals($field2->listable, false);
    }

    public function testUnlistPassword()
    {
        $options = 'required|type:password|min:8';
        $field1 = $this->newField($options);

        $options = [
            'type' => 'password',
        ];
        $field2 = $this->newField($options);

        $this->assertEquals($field1->listable, false);
        $this->assertEquals($field2->listable, false);
    }

    public function testCustomLabel()
    {
        $options = [
            'label' => 'Do not label me!',
        ];
        $field = $this->newField($options);

        $this->assertEquals($field->label, 'Do not label me!');
    }

    public function testHelpBlock()
    {
        $options = [
            'help' => 'Seeking help now!',
        ];
        $field = $this->newField($options);

        $this->assertEquals($field->help, 'Seeking help now!');
    }
}
