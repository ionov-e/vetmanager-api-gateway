<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Exception;

/** Значит получили 401-ую ошибку, но в сообщении не было 'Tariff expired' */
class VetmanagerApiGatewayUnauthorizedException extends VetmanagerApiGatewayException
{
}
