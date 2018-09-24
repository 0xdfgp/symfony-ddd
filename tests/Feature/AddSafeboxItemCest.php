<?php
declare(strict_types=1);

namespace App\Tests\Feature;

use App\Tests\FeatureTester;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class AddSafeboxItemCest
{
    public function itShouldAddANewItem(FeatureTester $I): void
    {
        $safebox = $I->createASafebox('A random name', 'MyPassword01');
        $token = $I->openASafebox($safebox['id'], 'MyPassword01', 3600);

        $I->haveHttpHeader('Authorization', "Bearer {$token['token']}");

        $I->sendPOST("/safebox/{$safebox['id']}", json_encode([
            'item' => 'New safebox content'
        ]));

        $I->seeResponseCodeIs(Response::HTTP_OK);
    }

    public function itShouldReturnUnauthorizedOnNotValidToken(FeatureTester $I): void
    {
        $safebox = $I->createASafebox('A random name', 'MyPassword01');

        $I->haveHttpHeader('Authorization', "Bearer invalid");

        $I->sendPOST("/safebox/{$safebox['id']}", json_encode([
            'item' => 'New safebox content'
        ]));

        $I->seeResponseCodeIs(Response::HTTP_UNAUTHORIZED);
    }

    public function itShouldLockTheSafebox(FeatureTester $I): void
    {
        $safebox = $I->createASafebox('locked safebox', 'MyPassword01');

        $I->openASafebox($safebox['id'], 'OtherPassword', 3600);
        $I->openASafebox($safebox['id'], 'OtherPassword', 3600);
        $I->openASafebox($safebox['id'], 'OtherPassword', 3600);

        $I->sendPOST("/safebox/{$safebox['id']}", json_encode([
            'item' => 'New safebox content'
        ]));

        $I->seeResponseCodeIs(Response::HTTP_LOCKED);
    }
}
