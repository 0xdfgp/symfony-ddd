<?php
declare(strict_types=1);

namespace App\Domain\Safebox;

use Doctrine\Common\Collections\ArrayCollection;

class Safebox
{
    private const MAX_ATTEMPTS = 3;

    /**
     * @var SafeboxId
     */
    private $id;

    /**
     * @var Name
     */
    private $name;

    /**
     * @var Password
     */
    private $password;

    /**
     * @var ArrayCollection
     */
    private $items;

    /**
     * @var int
     */
    private $remainingAttempts;

    /**
     * @var bool
     */
    private $locked;

    /**
     * Safebox constructor.
     *
     * @param SafeboxId     $id
     * @param Name          $name
     * @param PlainPassword $password
     * @param Item[]        $items
     */
    public function __construct(SafeboxId $id, Name $name, PlainPassword $password, array $items = [])
    {
        $this->id                = $id;
        $this->name              = $name;
        $this->remainingAttempts = self::MAX_ATTEMPTS;
        $this->locked            = false;
        $this->items             = new ArrayCollection($items);

        $this->hashPassword($password);
    }

    /**
     * @param PlainPassword $password
     */
    public function hashPassword(PlainPassword $password): void
    {
        $this->password = new Password(password_hash($password->value(), PASSWORD_DEFAULT));
    }

    /**
     * @return SafeboxId
     */
    public function id(): SafeboxId
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * @return Password
     */
    public function password(): Password
    {
        return $this->password;
    }

    /**
     * Checks if the given password is valid and throws an exception if it isn't.
     *
     * @param PlainPassword $password
     * @throws PasswordNotMatch
     * @throws SafeboxIsLocked
     */
    public function attemptPassword(PlainPassword $password): void
    {
        if ($this->locked) {
            throw new SafeboxIsLocked($this->id);
        }

        if (!$this->isValidPassword($password)) {
            $this->reduceRemainingAttempts();
            throw new PasswordNotMatch($password);
        }
        $this->resetPasswordAttempts();
    }

    /**
     * @param PlainPassword $password
     * @return bool
     */
    private function isValidPassword(PlainPassword $password): bool
    {
        return password_verify($password->value(), $this->password->value());
    }

    /**
     * Increments by one the attempts
     */
    private function reduceRemainingAttempts(): void
    {
        $this->remainingAttempts--;
        if ($this->remainingAttempts === 0) {
            $this->locked = true;
        }
    }

    private function resetPasswordAttempts(): void
    {
        $this->remainingAttempts = self::MAX_ATTEMPTS;
    }

    /**
     * @return bool
     */
    public function locked(): bool
    {
        return $this->locked;
    }

    /**
     * @param ItemId  $itemId
     * @param Content $content
     * @throws SafeboxIsLocked
     */
    public function addContent(ItemId $itemId, Content $content): void
    {
        if ($this->locked) {
            throw new SafeboxIsLocked($this->id);
        }
        $this->items->add(new Item($itemId, $content, $this));
    }

    /**
     * @return array
     */
    public function items(): array
    {
        return $this->items->toArray();
    }
}
