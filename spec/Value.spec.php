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

        context('when the value is an array', function () {

            it('should return array', function () {

                $value = new Value([]);

                $test = $value->type();

                expect($test)->toEqual('array');

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

        context('when the value is a string', function () {

            context('when the string shorter or equal than 40 characters', function () {

                it('should return a detailled representation of the full string', function () {

                    $string = implode('', array_pad([], 40, 'a'));

                    $value = new Value($string);

                    $test = $value->type();

                    expect($test)->toEqual('string (' . $string .')');

                });

            });

            context('when the string is longer than 40 characters', function () {

                it('should return a detailled representation of a truncated string', function () {

                    $string = implode('', array_pad([], 41, 'a'));
                    $truncated = implode('', array_pad([], 37, 'a')) . '...';

                    $value = new Value($string);

                    $test = $value->type();

                    expect($test)->toEqual('string (' . $truncated .')');

                });

            });

        });

        context('when the value is a callable', function () {

            context('when the callable is a function name', function () {

                it('should return a string representation of the function', function () {

                    function test () {};

                    $value = new Value('test');

                    $test = $value->type();

                    expect($test)->toEqual('callable (test)');

                });

            });

            context('when the callable is a string representation of a static method', function () {

                it('should return a string representation of the static method', function () {

                    $class = onStatic(mock(['static test' => function () {}]))->className();

                    $value = new Value($class . '::test');

                    $test = $value->type();

                    expect($test)->toEqual('callable (' . $class . '::test)');

                });

            });

            context('when the callable is an array representation of a static method', function () {

                it('should return a string representation of the static method', function () {

                    $class = onStatic(mock(['static test' => function () {}]))->className();

                    $value = new Value([$class, 'test']);

                    $test = $value->type();

                    expect($test)->toEqual('callable ([' . $class . ', test])');

                });

            });

            context('when the callable is an array representation of an instance method', function () {

                it('should return a string representation of the instance method', function () {

                    $instance = mock(['test' => function () {}])->get();

                    $value = new Value([$instance, 'test']);

                    $test = $value->type();

                    expect($test)->toEqual('callable ([' . get_class($instance) . ', test])');

                });

            });

            context('when the callable is an array representation of an anonymous instance method', function () {

                it('should return a string representation of the instance method', function () {

                    $instance = new class { function test () {} };

                    $value = new Value([$instance, 'test']);

                    $test = $value->type();

                    expect($test)->toEqual('callable ([object (anonymous class), test])');

                });

            });

        });

        context('when the value is an object', function () {

            context('when the object is anonymous', function () {

                it('should return the object class name', function () {

                    $object = new class {};

                    $value = new Value($object);

                    $test = $value->type();

                    expect($test)->toEqual('object (anonymous class)');

                });

            });

            context('when the object is not anonymous', function () {

                context('when the object is invokable', function () {

                    it('should return the object class name', function () {

                        $object = mock(['__invoke' => function () {}])->get();

                        $value = new Value($object);

                        $test = $value->type();

                        expect($test)->toEqual(get_class($object));

                    });

                });

                context('when the object is not invokable', function () {

                    it('should return the object class name', function () {

                        $object = new StdClass;

                        $value = new Value($object);

                        $test = $value->type();

                        expect($test)->toEqual(get_class($object));

                    });

                });

            });

        });

    });

});
