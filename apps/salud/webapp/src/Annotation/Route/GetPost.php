<?php

declare(strict_types=1);

namespace SocialApp\Apps\Salud\Webapp\Annotation\Route;

use Symfony\Component\Routing\Annotation\Route;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class GetPost extends Route
{
    public function getMethods(): array
    {
        return [
            HttpMethod::GET->name,
            HttpMethod::POST->name,
        ];
    }
}
