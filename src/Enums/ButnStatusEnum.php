<?php

namespace Ofload\Butn\Enums;

enum ButnStatusEnum: string
{
    case PENDING = 'pending';
    case PENDING_LOGIN_CREATED = 'Pending (Login Created)';
    case PASSED_ON_BOARDING_CHECKS = 'Passed Onboarding Checks';
    case REVIEW = 'Review';
    case WILL_NOT_FUND = 'Will not fund';
    case PENDING_AGREEMENT = 'Pending (Agreement)';
    case APPROVED = 'Approved';
    case INACTIVE_INELIGIBLE = 'Inactive - Ineligible';
    case INACTIVE_SUSPENDED = 'Inactive - Suspended';
    case INACTIVE_UNSUBSCRIBED = 'Inactive - Unsubscribed';
    case NOT_APPLICABLE = 'Not Applicable';
}
