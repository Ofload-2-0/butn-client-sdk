<?php

namespace Ofload\Butn;

final class ApplicationConstants
{
    // production specific
    const PRODUCTION_URL = 'https://login.salesforce.com';
    const PRODUCTION_BUTN_INSTANCE_URL = 'https://butn.my.salesforce.com';
    const PRODUCTION_APPLICATION_MODE = 'production';

    // sandbox specifics
    const SANDBOX_URL = 'https://test.salesforce.com';
    const SANDBOX_BUTN_INSTANCE_URL = 'https://butn--aggsandbox.my.salesforce.com';
    const SANDBOX_APPLICATION_MODE = 'sandbox';

    // common
    const VERSION_1 = 'v1';
    const VERSION_2 = 'v2';
    const VERSION_3 = 'v3';
    const VERSION_4 = 'v4';
    const VERSION_5 = 'v5';

    const TOKEN_URI = '/services/oauth2/token';
    const TRANSACTION_OPTIN_V1_URI = '/services/apexrest/v1/optIn/factor/transaction';
    const JWT_GRANT_TYPE = 'urn:ietf:params:oauth:grant-type:jwt-bearer';
    const BUTTON_PAY = 'Butn Pay';
    const BUTN_X_UNDISCLOSED = 'Butn X Undisclosed';
    const REGISTER_USER_URI = '/services/apexrest/{version}/borrower/register';
    const CHECK_USER_STATUS_URI = '/services/apexrest/{version}/borrower/status/';
    const CHECK_TRANSACTION_STATUS_URI = '/services/apexrest/{version}/factor/transaction/status/';

    public static function buildRegisterUserUri(string $version = self::VERSION_5): string
    {
        return str_replace('{version}', $version, self::REGISTER_USER_URI);
    }

    public static function buildCheckUserStatusUri(string $version = self::VERSION_3): string
    {
        return str_replace('{version}', $version, self::CHECK_USER_STATUS_URI);
    }

    public static function buildCheckTransactionStatusUri(string $version = self::VERSION_4): string
    {
        return str_replace('{version}', $version, self::CHECK_TRANSACTION_STATUS_URI);
    }
}
