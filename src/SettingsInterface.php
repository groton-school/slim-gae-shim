<?php

declare(strict_types=1);

namespace GrotonSchool\Slim\GAE;

interface SettingsInterface
{
    public function getProjectId(): string;
    public function getProjectUrl(): string;
}
