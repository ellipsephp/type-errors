<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Exceptions\TypeErrorMessage;

describe('TypeErrorMessage', function () {

    describe('->__toString()', function () {

        it('should return a string representation of the error', function () {

            $test = (string) new TypeErrorMessage('role', 'given', stdClass::class);

            $expected = 'Trying to use a value of type string (\'given\') as role - object implementing stdClass expected';

            expect($test)->toEqual($expected);

        });

    });

});
