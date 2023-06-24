<?php

declare(strict_types=1);

namespace SocialApp\Demo\BookCategory\Domain\Dto;

use SocialApp\Demo\BookCategory\Domain\Model\BookCategory;
use SocialApp\Shared\Domain\Dto\AbstractDto;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Validator\Constraints as Assert;

class BookCategoryDto extends AbstractDto
{
    public function __construct(
        #[Assert\Uuid]
        public ?AbstractUid $id = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 50, groups: ['create', 'Default'])]
        public ?string $name = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 255, groups: ['create', 'Default'])]
        public ?string $description = null,
    ) {
    }

    public static function fromModel(BookCategory $book): static
    {
        return new self(
            $book->id()->value,
            $book->name()->value,
            $book->description()->value,
        );
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
