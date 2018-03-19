<?php

use function Eloquent\Phony\Kahlan\mock;
use function Eloquent\Phony\Kahlan\onStatic;

use Ellipse\Exceptions\Value;

describe('Value', function () {

    describe('->type()', function () {

        context('when the value is a boolean', function () {

            it('should return boolean', function () {

                $value = new Value(true);

                $test = $value->type();

                expect($test)->toEqual('boolean');

            });

        });

        context('when the value is an integer', function () {

            it('should return integer', function () {

                $value = new Value(1);

                $test = $value->type();

                expect($test)->toEqual('integer');

            });

        });

        context('when the value is a float', function () {

            it('should return double', function () {

                $value = new Value(1.0);

                $test = $value->type();

                expect($test)->toEqual('double');

            });

        });

        context('when the value is a string', function () {

            context('when the string shorter or equal than 40 characters', function () {

                it('should return a detailled representation of the full string', function () {

                    $string = implode('', array_pad([], 40, 'a'));

                    $value = new Value($string);

                    $test = $value->type();

                    expect($test)->toEqual('string (\'' . $string .'\')');

                });

            });

            context('when the string is longer than 40 characters', function () {

                it('should return a detailled representation of a truncated string', function () {

                    $string = implode('', array_pad([], 41, 'a'));
                    $truncated = implode('', array_pad([], 37, 'a')) . '...';

                    $value = new Value($string);

                    $test = $value->type();

                    expect($test)->toEqual('string (\'' . $truncated .'\')');

                });

            });

        });

        context('when the value is an array', function () {

            it('should display a string representation of boolean elements', function () {

                $value = new Value([true, false]);

                $test = $value->type();

                expect($test)->toEqual('array ([0 => true, 1 => false])');

            });

            it('should display a string representation of integer elements', function () {

                $value = new Value([1]);

                $test = $value->type();

                expect($test)->toEqual('array ([0 => 1])');

            });

            it('should display a string representation of float elements', function () {

                $value = new Value([1.1]);

                $test = $value->type();

                expect($test)->toEqual('array ([0 => 1.1])');

            });

            it('should display a string representation of string elements', function () {

                $value = new Value(['string', 'abcdefghijk']);

                $test = $value->type();

                expect($test)->toEqual('array ([0 => \'string\', 1 => \'abcdefg...\'])');

            });

            it('should display a string representation of array elements', function () {

                $value = new Value([['array']]);

                $test = $value->type();

                expect($test)->toEqual('array ([0 => [...]])');

            });

            it('should display a string representation of object elements', function () {

                $value = new Value([new stdClass, new class {}]);

                $test = $value->type();

                expect($test)->toEqual('array ([0 => stdClass, 1 => object])');

            });

            it('should display a string representation of resource elements', function () {

                $value = new Value([fopen('php://memory', 'r')]);

                $test = $value->type();

                expect($test)->toEqual('array ([0 => resource])');

            });

            it('should display a string representation of null elements', function () {

                $value = new Value([null]);

                $test = $value->type();

                expect($test)->toEqual('array ([0 => NULL])');

            });

            it('should display a string representation of string keys', function () {

                $value = new Value(['key' => 'value']);

                $test = $value->type();

                expect($test)->toEqual('array ([\'key\' => \'value\'])');

            });

            context('when the array has less than or exactly 3 elements', function () {

                it('should dispaly all the elements', function () {

                    $value = new Value(['v0', 'v1', 'v2']);

                    $test = $value->type();

                    expect($test)->toEqual('array ([0 => \'v0\', 1 => \'v1\', 2 => \'v2\'])');
                });

            });

            context('when the array has more than 3 elements', function () {

                it('should dispaly the first two and an ellipsis', function () {

                    $value = new Value(['v0', 'v1', 'v2', 'v3']);

                    $test = $value->type();

                    expect($test)->toEqual('array ([0 => \'v0\', 1 => \'v1\', ...])');

                });

            });

        });

        context('when the value is an object', function () {

            context('when the object is anonymous', function () {

                it('should return the object class name', function () {

                    $value = new Value(new class {});

                    $test = $value->type();

                    expect($test)->toEqual('object');

                });

            });

            context('when the object is not anonymous', function () {

                it('should return the object class name', function () {

                    $value = new Value(new stdClass);

                    $test = $value->type();

                    expect($test)->toEqual(stdClass::class);

                });

            });

        });

        context('when the value is a resource', function () {

            it('should return resource', function () {

                $value = new Value(fopen('php://memory', 'r'));

                $test = $value->type();

                expect($test)->toEqual('resource');

            });

        });

        context('when the value is null', function () {

            it('should return NULL', function () {

                $value = new Value(null);

                $test = $value->type();

                expect($test)->toEqual('NULL');

            });

        });

    });

});
