<?php

declare(strict_types=1);

namespace SocialApp\Apps\Financiero\Webapp\Annotation\Route;

enum HttpMethod
{
    case GET;
    case POST;
    case HEAD;
    case OPTIONS;
    case PATCH;
    case PUT;
    case DELETE;
}
