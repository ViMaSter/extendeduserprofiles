<?php
    namespace ExtendedUserProfiles
    {
        class OHIDataAuthenticationProvider extends \MediaWiki\Auth\AbstractPreAuthenticationProvider
        {
            public function getAuthenticationRequests($action, array $options)
            {
                if ($action == \MediaWiki\Auth\AuthManager::ACTION_CREATE)
                {
                    return [new OHIDataAuthenticationRequest()];
                }
            }
        }

        /**
         * Authentication request for the reason given for account creation.
         * Used in logs and for notification.
         */
        class OHIDataAuthenticationRequest extends \MediaWiki\Auth\AuthenticationRequest {
            /** @var string Account creation reason (only used when creating for someone else) */
            public $reason;

            public $required = self::REQUIRED;

            public function getFieldInfo() {
                $yearOptions = array();
                $currentYear = (int)date('Y');
                for ($i = 1800; $i <= $currentYear; $i++)
                {
                    $yearOptions[(string)$i] = wfMessage((string)$i);
                }
                return [
                    'birthyear' => [ // yes, this is the year, not the precise date - done so intentionally to not require to much data from users
                        'type' => 'select',
                        'label' => wfMessage( 'extendeduserprofiles-createaccount-birthyear' ),
                        'help' => wfMessage( 'extendeduserprofiles-createaccount-birthyear-help' ),
        				'options' => $yearOptions
                    ],
                    'gender' => [
                        'type' => 'string',
                        'label' => wfMessage( 'extendeduserprofiles-createaccount-gender' ),
                        'help' => wfMessage( 'extendeduserprofiles-createaccount-gender-help' ),
                    ],
                    'highest-educational-attainment' => [
                        'type' => 'string',
                        'label' => wfMessage( 'extendeduserprofiles-createaccount-highest-educational-attainment' ),
                        'help' => wfMessage( 'extendeduserprofiles-createaccount-highest-educational-attainment-help' ),
                    ],
                ];
            }
        }
    }
