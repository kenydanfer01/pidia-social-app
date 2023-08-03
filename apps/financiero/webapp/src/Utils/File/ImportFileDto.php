<?php

namespace SocialApp\Apps\Financiero\Webapp\Utils\File;

class ImportFileDto
{
    private $file;

    public function file()
    {
        return $this->file;
    }

    public function setFile($file): void
    {
        $this->file = $file;
    }
}
