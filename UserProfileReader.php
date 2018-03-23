<?php
    namespace ExtendedUserProfiles
    {
        class UserPropertiesHelper
        {
            static function getCurrentUserID() {
                return \User::getId();
            }

            static function getUserById( $id ) {
                $currentUser = \User::newFromId($id);
                if ($currentUser->loadFromId()) {
                    return $currentUser;
                }
                else {
                    return NULL;
                }
            }

            static function getUserByName( $name ) {
                $userID = \User::idFromName($name);
                if ($userID <= 0)
                {
                    return NULL;
                }

                $currentUser = \User::newFromId($userID);
                if ($currentUser->loadFromId()) {
                    return $currentUser;
                }
                else {
                    return NULL;
                }
            }

            static function getCurrentUser() {
                global $wgUser;
                assert($wgUser->isSafeToLoad(), "Can't load user yet!");
                return $wgUser->getId() <= 0 ? NULL : $wgUser;
            }
        }

        class UserPropertiesReader {
            public static function init(\Parser &$parser) {
                $parser->setFunctionHook( 'currentUserPropertyEcho',   array( __CLASS__, 'currentUserPropertyEcho' ) );
                $parser->setFunctionHook( 'currentUserPropertyExists', array( __CLASS__, 'currentUserPropertyExists' ) );
                $parser->setFunctionHook( 'userByNamePropertyEcho',          array( __CLASS__, 'userByNamePropertyEcho' ) );
                $parser->setFunctionHook( 'userByNamePropertyExists',        array( __CLASS__, 'userByNamePropertyExists' ) );
                $parser->setFunctionHook( 'userByIDPropertyEcho',          array( __CLASS__, 'userByIDPropertyEcho' ) );
                $parser->setFunctionHook( 'userByIDPropertyExists',        array( __CLASS__, 'userByIDPropertyExists' ) );

                return true;
            }

            static function currentUserPropertyEcho( \Parser &$parser, $varName, $defaultValue = ''  ) {
                $currentUser = UserPropertiesHelper::getCurrentUser();
                if ($currentUser)
                {
                    return $currentUser->getOption($varName, $defaultValue);
                }
                else {
                    return $defaultValue;
                }
            }

            static function currentUserPropertyExists( \Parser &$parser, $varName ) {
                $currentUser = UserPropertiesHelper::getCurrentUser();
                return $currentUser->getOption($varName, NULL) != NULL;
            }

            static function userByNamePropertyEcho( \Parser &$parser, $userId, $varName, $defaultValue = '' ) {
                $currentUser = UserPropertiesHelper::getUserByName( $userId );
                if ($currentUser)
                {
                    return $currentUser->getOption($varName, $defaultValue);
                }
                else {
                    return $defaultValue;
                }
            }

            static function userByNamePropertyExists( \Parser &$parser, $userId, $varName  ) {
                $currentUser = UserPropertiesHelper::getUserByName( $userId );
                return $currentUser->getOption($varName, NULL) != NULL;
                return true;
            }

            static function userByIDPropertyEcho( \Parser &$parser, $userId, $varName, $defaultValue = '' ) {
                $currentUser = UserPropertiesHelper::getUserById( $userId );
                if ($currentUser)
                {
                    return $currentUser->getOption($varName, $defaultValue);
                }
                else {
                    return $defaultValue;
                }
            }

            static function userByIDPropertyExists( \Parser &$parser, $userId, $varName  ) {
                $currentUser = UserPropertiesHelper::getUserById( $userId );
                return $currentUser->getOption($varName, NULL) != NULL;
                return true;
            }
        }
    }
