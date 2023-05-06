<?php

namespace VetmanagerApiGateway\ActiveRecord\Interface;

interface AllGetRequestsInterface extends
    BasicDAOInterface,
    RequestGetAllInterface,
    RequestGetByIdInterface,
    RequestGetByQueryInterface
{
}
