<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookStore\Application\Command;

use SocialApp\Demo\BookStore\Domain\ValueObject\BookId;
use SocialApp\Demo\BookStore\Domain\ValueObject\Discount;
use SocialApp\Shared\Application\Command\CommandInterface;

final class DiscountBookCommand implements CommandInterface
{
    public function __construct(
        public readonly BookId $id,
        public readonly Discount $discount,
    ) {
    }
}
