<?php

namespace Ofload\Butn\Enums;

enum InstallmentFrequency: string
{
    case ONE_OFF = 'One off';
    case DAILY = 'Daily';
    case WEEKLY = 'Weekly';
    case MONTHLY = 'Monthly';
    case QUARTERLY = 'Quarterly';
    case BIANNUAL = 'Biannual';
    case ANNUAL = 'Annual';
    case FORT_NIGHTLY = 'Fortnightly';
}