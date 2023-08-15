<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

interface DeletableInterface
{
    public function delete(): void;
}