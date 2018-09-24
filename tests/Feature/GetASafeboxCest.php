<?php
declare(strict_types=1);

namespace App\Tests\Feature;

use App\Tests\FeatureTester;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class GetASafeboxCest
{
    public function itShouldAddANewItem(FeatureTester $I): void
    {
        $safebox = $I->createASafebox('A random name', 'MyPassword01');
        $token = $I->openASafebox($safebox['id'], 'MyPassword01', 3600);
        $I->addASafeboxItem($token['token'], $safebox['id'], 'My item 1');
        $I->addASafeboxItem($token['token'], $safebox['id'], 'My item 2');

        $I->haveHttpHeader('Authorization', "Bearer {$token['token']}");
        $I->sendGET("/safebox/{$safebox['id']}");

        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseContainsJson([
            'items' => [
                'My item 1',
                'My item 2',
            ]
        ]);
    }

    public function itShouldReturnUnauthorizedOnNotValidToken(FeatureTester $I): void
    {
        $safebox = $I->createASafebox('A random name', 'MyPassword01');

        $I->haveHttpHeader('Authorization', "Bearer invalid");

        $I->sendGET("/safebox/{$safebox['id']}");

        $I->seeResponseCodeIs(Response::HTTP_UNAUTHORIZED);
    }

    public function itShouldLockTheSafebox(FeatureTester $I): void
    {
        $safebox = $I->createASafebox('locked safebox', 'MyPassword01');
        $token = $I->openASafebox($safebox['id'], 'MyPassword01', 3600);

        $I->openASafebox($safebox['id'], 'OtherPassword', 3600);
        $I->openASafebox($safebox['id'], 'OtherPassword', 3600);
        $I->openASafebox($safebox['id'], 'OtherPassword', 3600);

        $I->haveHttpHeader('Authorization', "Bearer {$token['token']}");
        $I->sendGET("/safebox/{$safebox['id']}");

        $I->seeResponseCodeIs(Response::HTTP_LOCKED);
    }
}
