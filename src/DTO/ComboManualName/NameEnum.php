<?php

namespace VetmanagerApiGateway\DTO\ComboManualName;

enum NameEnum: string
{
    /** Тип приема */
    case AdmissionType = 'admission_type';
    /** Исход приема */
    case AdmissionResult = 'admission_result';
    /** Типы печатных форм */
    case PrintTypes = 'printform_types';
    /** Формат печатной формы */
    case PrintFormat = 'printform_format';
    /** Тип шаблона */
    case TemplateType = 'template_type';
    /** Тип рассылки */
    case SendType = 'send_type';
    /** Как нашли клинику */
    case HowFindClinic = 'how_find_clinic';
    /** Окрасы животных */
    case PetColors = 'pet_colors';
    /** Способ рассылки */
    case DistributionMethod = 'distribution_method';
    /** Тип комбинации */
    case CombinationType = 'combination_type';
    /** Сервисы для хук-уведомлений */
    case ServicesForHooks = 'services_for_hooks';
    /** Производители */
    case Manufacturers = 'manufacturers';
    /** Тип вакцинации */
    case VaccinationType = 'vaccination_type';
    /** Вид входящего документа */
    case IncomingDocumentType = 'incoming_document_type';
    /** Типы диагнозов */
    case DiagnoseTypes = 'diagnos_types';
    /** VOIP Тип звонка */
    case VoipCallType = 'voip_call_type';
    /** VOIP Результат звонка */
    case VoipCallResult = 'voip_call_result';
    /** Каналы для записи на прием */
    case AppointmentChannels = 'appointment_channels';
    /** Шаблоны премии / штрафы */
    case TemplatesBonusPenalty = 'templates_bonus_penalty';
}
