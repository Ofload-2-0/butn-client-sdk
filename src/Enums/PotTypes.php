<?php

namespace Ofload\Butn\Enums;

enum PotTypes: string
{
    case INVOICE = 'Invoice';
    case COMMISSION_STATEMENT = 'Commission Statement';
    case PROGRESS_CLAIM = 'Progress Claim';
    case PURCHASE_ORDER = 'Purchase Order';
    case RGTI = 'RGTI';
    case DIRECTION_TO_PAY = 'Direction to Pay';
    case OTHER = 'Other';
    case AGENCY_AGREEMENT = 'Agency Agreement';
    case CONTRACT_OF_SALE = 'Contract of Sale';
}