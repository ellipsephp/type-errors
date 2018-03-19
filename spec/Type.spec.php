<?php

use Ellipse\Exceptions\Type;

describe('Type', function () {

    describe('->__toString()', function () {

        context('when the type is not an interface or class name', function () {

            it('should return the type', function () {

                $test = (string) new Type('type');

                expect($test)->toEqual('type');

            });

        });

        context('when the type is an interface or class name', function () {

            context('when the type is an interface name', function () {

                it('should return a string respresentation of the interface name', function () {

                    $test = (string) new Type(Iterator::class);

                    expect($test)->toEqual('object implementing Iterator');

                });

            });

            context('when the type is a class name', function () {

                it('should return a string respresentation of the class name', function () {

                    $test = (string) new Type(stdClass::class);

                    expect($test)->toEqual('object implementing stdClass');

                });

            });

        });

    });

});
