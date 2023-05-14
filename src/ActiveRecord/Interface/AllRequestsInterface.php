<?php

namespace VetmanagerApiGateway\ActiveRecord\Interface;

interface AllRequestsInterface extends
    AllGetRequestsInterface,
    RequestPostInterface,
    RequestPutInterface
{
}
