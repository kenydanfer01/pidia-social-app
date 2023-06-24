<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Demo\BookCategory\Domain\Model;

use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryDescription;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryId;
use SocialApp\Demo\BookCategory\Domain\ValueObject\BookCategoryName;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class BookCategory
{
    #[ORM\Embedded(columnPrefix: false)]
    private readonly BookCategoryId $id;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private BookCategoryName $name,

        #[ORM\Embedded(columnPrefix: false)]
        private BookCategoryDescription $description,
    ) {
        $this->id = new BookCategoryId();
    }

    public function update(
        ?BookCategoryName $name = null,
        ?BookCategoryDescription $description = null,
    ): void {
        $this->name = $name ?? $this->name;
        $this->description = $description ?? $this->description;
    }

    public function id(): BookCategoryId
    {
        return $this->id;
    }

    public function name(): BookCategoryName
    {
        return $this->name;
    }

    public function description(): BookCategoryDescription
    {
        return $this->description;
    }
}
