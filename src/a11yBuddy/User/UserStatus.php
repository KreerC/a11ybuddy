<?php

/*
   Copyright 2024 Casey Kreer

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

namespace A11yBuddy\User;

class UserStatus
{

    /**
     * The user has not verified their account yet, e.g. using an email address.
     */
    const UNVERIFIED = 0;

    /**
     * The user has verified their account. The account is fully functional.
     */
    const VERIFIED = 1;

    /**
     * The user's account has been suspended. They cannot log in or use the application.
     */
    const SUSPENDED = 2;


    const DELETED = 3;

    /**
     * The user has elevated privileges, e.g. they are an administrator.
     */
    const PRIVILEGED = 10;


}