<?php
declare(strict_types=1);

namespace App\Tests\Feature;

use App\Tests\FeatureTester;
use Symfony\Component\HttpFoundation\Response;

class CreateASafeboxCest
{
    public function itShouldCreateASafebox(FeatureTester $I): void
    {
        $I->sendPOST('/safebox', json_encode([
            'name'     => 'A random name',
            'password' => 'MyPassword34!'
        ]));

        $I->seeResponseCodeIs(Response::HTTP_OK);
    }

    public function itShouldReturnABadRequestOnEmptyName(FeatureTester $I): void
    {
        $I->sendPOST('/safebox', json_encode([
            'name'     => '',
            'password' => 'MyPassword34!'
        ]));

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function itShouldReturnABadRequestOnNotValidPassword(FeatureTester $I): void
    {
        $I->sendPOST('/safebox', json_encode([
            'name'     => 'A random name',
            'password' => '12345'
        ]));

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function itShouldReturnABadRequestOnForbiddenPassword(FeatureTester $I): void
    {
        $I->sendPOST('/safebox', json_encode([
            'name'     => 'A random name',
            'password' => 'ncc1701'
        ]));

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }
}
