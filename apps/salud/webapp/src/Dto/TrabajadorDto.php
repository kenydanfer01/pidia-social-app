<?php

namespace SocialApp\Apps\Salud\Webapp\Dto;

use SocialApp\Shared\Domain\Dto\AbstractDto;

class TrabajadorDto extends AbstractDto
{

    public ?string $nombre = null;
    public ?string $apellidos = null;

    public function __toString()
    {
        return '';
    }
}
