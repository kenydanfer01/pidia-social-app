<?php

namespace SocialApp\Apps\Financiero\Webapp\Service\credito;

use CarlosChininin\Util\Pagination\PaginatedData;
use CarlosChininin\Util\Pagination\PaginationDto;
use CarlosChininin\Util\Pagination\DoctrinePaginator;
use SocialApp\Apps\Financiero\Webapp\Filter\Dto\CreditoFilterDto;
use SocialApp\Apps\Financiero\Webapp\Repository\CreditoRepository;

class GetPaginatedCreditos
{
    public function __construct(
        private creditoRepository $creditoRepository,
    ) {
    }

    public function execute(CreditoFilterDto $filterDto): PaginatedData
    {
        $pagination = PaginationDto::create($filterDto->page, $filterDto->limit);
        $dataQuery = $this->creditoRepository->filterQueryPaginated($filterDto);

        return (new DoctrinePaginator())->paginate($dataQuery, $pagination);
    }
}
