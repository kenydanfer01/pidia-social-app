<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Shared\Infrastructure\Api;

use SocialApp\Shared\Domain\Repository\PaginatorInterface;

final class Paginator implements \IteratorAggregate
{
    public const PAGE = 1;
    public const ITEM_PER_PAGE = 10;

    /**
     * @param \Traversable<T> $items
     */
    public function __construct(
        private readonly \Traversable $items,
        private readonly int $currentPage,
        private readonly int $itemsPerPage,
        private readonly int $lastPage,
        private readonly int $totalItems,
    ) {
    }

    public static function ofModel(array $resources, PaginatorInterface $paginator): self
    {
        return new self(
            new \ArrayIterator($resources),
            $paginator->getCurrentPage(),
            $paginator->getItemsPerPage(),
            $paginator->getLastPage(),
            $paginator->getTotalItems(),
        );
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }

    public function itemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function lastPage(): int
    {
        return $this->lastPage;
    }

    public function totalItems(): int
    {
        return $this->totalItems;
    }

    public function count(): int
    {
        return iterator_count($this->getIterator());
    }

    public function hasPreviousPage(): bool
    {
        return $this->currentPage() > 1;
    }

    public function previousPage(): int
    {
        return max(1, $this->currentPage() - 1);
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage() < $this->lastPage();
    }

    public function nextPage(): int
    {
        return min($this->lastPage(), $this->currentPage() + 1);
    }

    public function hasToPaginate(): bool
    {
        return $this->totalItems() > $this->itemsPerPage();
    }

    public function index(int $index): int
    {
        return ($this->currentPage() - 1) * $this->itemsPerPage() + $index;
    }

    public function indexReversed(int $index): int
    {
        return $this->totalItems() - $this->index($index) + 1;
    }

    public function startIndex(): int
    {
        return ($this->currentPage() - 1) * $this->itemsPerPage() + 1;
    }

    public function endIndex(): int
    {
        return ($this->startIndex() - 1) + $this->totalItems();
    }

    /**
     * @return \Traversable<T>
     */
    public function getIterator(): \Traversable
    {
        return $this->items;
    }
}
