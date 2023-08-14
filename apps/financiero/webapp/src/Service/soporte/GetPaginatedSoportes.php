<?php

namespace SocialApp\Apps\Financiero\Webapp\Service\soporte;

use CarlosChininin\Util\Pagination\PaginatedData;
use CarlosChininin\Util\Pagination\PaginationDto;
use CarlosChininin\Util\Pagination\DoctrinePaginator;
use SocialApp\Apps\Financiero\Webapp\Filter\Dto\SoporteFilterDto;
use SocialApp\Apps\Financiero\Webapp\Repository\SoporteRepository;

class GetPaginatedSoportes
{
    public function __construct(
        private SoporteRepository $soporteRepository,
    ) {
    }

    public function execute(SoporteFilterDto $filterDto): PaginatedData
    {
        $pagination = PaginationDto::create($filterDto->page, $filterDto->limit);
        $dataQuery = $this->soporteRepository->filterQueryPaginated($filterDto);

        return (new DoctrinePaginator())->paginate($dataQuery, $pagination);
    }
}
