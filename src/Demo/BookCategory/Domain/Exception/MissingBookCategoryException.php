<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Domain\Exception;

use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;

final class MissingBookCategoryException extends \RuntimeException
{
    public function __construct(BookCategoryId $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Cannot find book with id %s', (string) $id), $code, $previous);
    }
}
