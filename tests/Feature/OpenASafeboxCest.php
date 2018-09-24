<?php
declare(strict_types=1);

namespace App\Tests\Feature;

use App\Tests\FeatureTester;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class OpenASafeboxCest
{
    public function itShouldOpenASafebox(FeatureTester $I): void
    {
        $safebox = $I->createASafebox('A random name', 'MyPassword01');

        $I->openASafebox($safebox['id'], 'MyPassword01', 3600);

        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseMatchesJsonType(['token' => 'string']);
    }

    public function itShouldReturnNotFoundOnMissingSafebox(FeatureTester $I): void
    {
        $id = Uuid::uuid1()->toString();

        $I->haveHttpHeader('password', 'MyPassword01');

        $I->sendPOST("/safebox/{$id}/open", json_encode([
            'expirationTime' => 3600
        ]));

        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
    }

    public function itShouldReturnABadRequestOnNotValidPassword(FeatureTester $I): void
    {
        $safebox = $I->createASafebox('A random name', 'MyPassword01');

        $I->haveHttpHeader('password', 'OtherPassword');

        $I->sendPOST("/safebox/{$safebox['id']}/open", json_encode([
            'expirationTime' => 3600
        ]));

        $I->seeResponseCodeIs(Response::HTTP_UNAUTHORIZED);
    }

    public function itShouldLockTheSafebox(FeatureTester $I): void
    {
        $safebox = $I->createASafebox('locked safebox', 'MyPassword01');

        $I->openASafebox($safebox['id'], 'OtherPassword', 3600);
        $I->openASafebox($safebox['id'], 'OtherPassword', 3600);
        $I->openASafebox($safebox['id'], 'OtherPassword', 3600);

        $I->sendPOST("/safebox/{$safebox['id']}/open", json_encode([
            'expirationTime' => 3600
        ]));

        $I->seeResponseCodeIs(Response::HTTP_LOCKED);
    }
}
