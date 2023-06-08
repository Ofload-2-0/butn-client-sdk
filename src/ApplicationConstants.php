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
    const VERSION = 'v1';
    const TOKEN_URI = '/services/oauth2/token';
    const TRANSACTION_OPTIN_V1_URI = '/services/apexrest/v1/optIn/factor/transaction';
    const JWT_GRANT_TYPE = 'urn:ietf:params:oauth:grant-type:jwt-bearer';
    const BUTTON_PAY = 'Butn Pay';
    const BUTN_X_UNDISCLOSED = 'Butn X Undisclosed';
    const REGISTER_USER_URI = '/services/apexrest/v2/borrower/register';
}
