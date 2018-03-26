<?php
    namespace ExtendedUserProfiles
    {
        class OHIDataAuthenticationProvider extends \MediaWiki\Auth\AbstractSecondaryAuthenticationProvider
        {
            public function getAuthenticationRequests($action, array $options)
            {
                if ($action == \MediaWiki\Auth\AuthManager::ACTION_CREATE)
                {
                    return [new OHIDataAuthenticationRequest()];
                }
                return [];
            }

        	public function beginSecondaryAuthentication($user, array $reqs ) {
                return \MediaWiki\Auth\AuthenticationResponse::newPass();
            }

        	public function beginSecondaryAccountCreation($user, $creator, array $reqs ) {
                $OHIRequest = NULL;
                foreach ($reqs as $key => $value)
                {
                    if (is_a($value, "ExtendedUserProfiles\OHIDataAuthenticationRequest"))
                    {
                        $OHIRequest = $value;
                        break;
                    }
                }

                if ($OHIRequest == NULL)
                {
                    return \MediaWiki\Auth\AuthenticationResponse::newFail(wfMessage('extendeduserprofiles-error-couldnt-resolve-request-in-creation'));
                }

                $user->setOption( 'birthyear', $OHIRequest->{'birthyear'} );
                $user->setOption( 'gender', $OHIRequest->{'gender'} );
                $user->setOption( 'highest-educational-attainment', $OHIRequest->{'highest-educational-attainment'} );
                $user->saveSettings();
                return \MediaWiki\Auth\AuthenticationResponse::newPass();
            }

            public function testForAccountCreation($user, $creator, array $reqs ) {
                $OHIRequest = NULL;
                foreach ($reqs as $key => $value)
                {
                    if (is_a($value, "ExtendedUserProfiles\OHIDataAuthenticationRequest"))
                    {
                        $OHIRequest = $value;
                        break;
                    }
                }

                if ($OHIRequest == NULL)
                {
                    return \StatusValue::newFatal( 'extendeduserprofiles-error-couldnt-resolve-request' );
                }

        		if ( $OHIRequest->{'birthyear'} !== null && $OHIRequest->{'birthyear'} !== '' ) {
                    if ( $OHIRequest->{'birthyear'} < $OHIRequest::$allowedYearRange[0] ) {
                        return \StatusValue::newFatal( 'extendeduserprofiles-error-birthyear-too-low' );
                    }
        			if ( $OHIRequest->{'birthyear'} > $OHIRequest::$allowedYearRange[1] ) {
        				return \StatusValue::newFatal( 'extendeduserprofiles-error-birthyear-too-high' );
        			}
        		} else {
                    return \StatusValue::newFatal( 'extendeduserprofiles-error-birthyear-empty' );
                }

        		if ( $OHIRequest->{'gender'} === null || $OHIRequest->{'gender'} === '' ) {
                    return \StatusValue::newFatal( 'extendeduserprofiles-error-gender-empty' );
                }
        		if ( $OHIRequest->{'highest-educational-attainment'} === null || $OHIRequest->{'highest-educational-attainment'} === '' ) {
                    return \StatusValue::newFatal( 'extendeduserprofiles-error-highest-educational-attainment-empty' );
                }

                $message = new \Message('extendeduserprofiles-userpage-default-content');
                $content = str_replace('\\', "", $message->parse());
                $content = sprintf($content, $user->getName());

				$context = new \RequestContext();
				$context->setTitle( $user->getUserPage() );
                $article = \Article::newFromTitle($user->getUserPage(), $context);
                $page = $article->getPage();
                $summaryMessage = new \Message('extendeduserprofiles-userpage-default-summary');
                $page->doEditContent(new \WikitextContent($content), $summaryMessage->parse());

        		return \StatusValue::newGood();
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

            public static $allowedYearRange = [];

            function __construct()
            {
                self::$allowedYearRange = [1900, (int)date('Y')];
            }

            public function getFieldInfo() {
                $yearOptions = array();
                for ($i = self::$allowedYearRange[0]; $i <= self::$allowedYearRange[1]; $i++) {
                    $yearOptions[(string)$i] = wfMessage("extendeduserprofiles-birthyear", (string)$i);
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
