<?php

namespace VetmanagerApiGateway\DTO\DAO\Interface;

interface AllGetRequestsInterface extends
    BasicDAOInterface,
    RequestGetAllInterface,
    RequestGetByIdInterface,
    RequestGetByQueryInterface
{
}
