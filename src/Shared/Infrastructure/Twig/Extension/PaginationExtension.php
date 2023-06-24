<?php

declare(strict_types=1);

namespace SocialApp\Shared\Infrastructure\Twig\Extension;

use SocialApp\Shared\Infrastructure\Api\Paginator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PaginationExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('index', [$this, 'indexFilter']),
            new TwigFilter('indexReverse', [$this, 'indexReverseFilter']),
            new TwigFilter('indexCountReverse', [$this, 'indexCountReverseFilter']),
        ];
    }

    public function indexFilter(int $index, Paginator $paginator): int
    {
        return $paginator->index($index);
    }

    public function indexReverseFilter(int $index, Paginator $paginator): int
    {
        return $paginator->totalItems() - $paginator->index($index) + 1;
    }

    public function indexCountReverseFilter(int $index, int $total): int
    {
        return $total - $index + 1;
    }
}
