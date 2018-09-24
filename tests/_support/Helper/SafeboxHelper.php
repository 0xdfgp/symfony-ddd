<?php
declare(strict_types=1);

namespace App\Tests\_support\Helper;

use Codeception\Module;

class SafeboxHelper extends Module
{
    public function createASafebox(string $name, string $password): array
    {
        /** @var Module\REST $rest */
        $rest = $this->getModule('REST');

        $rest->sendPOST('/safebox', json_encode([
            'name'     => $name,
            'password' => $password,
        ]));

        return json_decode($rest->grabResponse(), true);
    }

    public function openASafebox(string $id, string $password, int $expirationTime): array
    {
        /** @var Module\REST $rest */
        $rest = $this->getModule('REST');

        $rest->haveHttpHeader('password', $password);

        $rest->sendPOST("/safebox/{$id}/open", json_encode([
            'expirationTime' => $expirationTime
        ]));

        return json_decode($rest->grabResponse(), true);
    }

    public function addASafeboxItem(string $token, string $id, string $item): array
    {
        /** @var Module\REST $rest */
        $rest = $this->getModule('REST');

        $rest->haveHttpHeader('Authorization', "Bearer {$token}");

        $rest->sendPOST("/safebox/{$id}", json_encode([
            'item' => $item
        ]));

        return json_decode($rest->grabResponse(), true);
    }
}
