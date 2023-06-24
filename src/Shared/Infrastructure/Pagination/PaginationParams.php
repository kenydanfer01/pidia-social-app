<?php

declare(strict_types=1);

namespace SocialApp\Shared\Infrastructure\Pagination;

use CarlosChininin\Util\Http\ParamFetcher;
use SocialApp\Shared\Domain\ValueObject\SearchText;
use SocialApp\Shared\Infrastructure\Api\Paginator;

final class PaginationParams
{
    public function __construct(
        public readonly ?SearchText $searchText = null,
        public readonly ?int $page = null,
        public readonly ?int $itemsPerPage = null,
    ) {
    }

    public static function ofRequest(ParamFetcher $params): self
    {
        $text = $params->getNullableString('b');
        return new self(
            $text ? new SearchText($text) : null,
            $params->getNullableInt('page') ?? Paginator::PAGE,
            $params->getNullableInt('limit') ?? Paginator::ITEM_PER_PAGE,
        );
    }
}
