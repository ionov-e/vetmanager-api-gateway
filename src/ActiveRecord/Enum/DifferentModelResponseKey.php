<?php

namespace VetmanagerApiGateway\ActiveRecord\Enum;

/** Здесь перечислены ключи моделей из АПИ-ответов, отличающиеся от имен моделей, использующихся в роутах АПИ-запросов
 *
 * Например: Get-запрос на получение всех медкарт по ID клиента будет получаться по адресу:
 * /rest/api/MedicalCards/MedicalcardsDataByClient?client_id={{ID}}
 * А ответ придет в виде JSON: { "success": true, "data": { "medicalcards": [{...},{...}] } }.
 * То есть не совпадает "MedicalCards/MedicalcardsDataByClient" из url и "medicalcards" из ответа.
 */
enum DifferentModelResponseKey: string
{
    case MedicalCards = 'medicalcards';
}
