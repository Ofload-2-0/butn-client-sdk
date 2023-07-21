<?php

namespace Ofload\Butn\Enums;

enum TransactionStatusEnum: string
{
    case DRAFT = 'Draft';
    case NOA_OUT_FOR_SIGNATURE = 'NoA Out For Signature';
    case CLOSED = 'Closed';
    case ACCEPTED = 'Accepted';
    case ACTIVE = 'Active';
    case AWAITING_FUNDS_RELEASE = 'Awaiting Funds Release';
    case CANCELLED = 'Cancelled';
    case IRREGULAR = 'Irregular';
    case UNABLE_TO_FUND = 'Unable to fund';
    case UNSERVICEABLE = 'Unserviceable';
    case FEES_OUTSTANDING = 'Fees outstanding';
    case FEES_OUTSTANDING_IRREGULAR = 'Fees outstanding - Irregular';
    case REVIEW = 'Review';
}
