<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Exceptions\ContainerEntryTypeErrorMessage;

describe('ContainerEntryTypeErrorMessage', function () {

    describe('->__toString()', function () {

        it('should return a string representation of the error', function () {

            $test = (string) new ContainerEntryTypeErrorMessage('id', 'retrieved', stdClass::class);

            $expected = 'The \'id\' entry of the container has type string (\'retrieved\') - object implementing stdClass expected';

            expect($test)->toEqual($expected);

        });

    });

});
