<?php

namespace A11yBuddy\User;

enum UserStatus: int
{

    /**
     * The user has not verified their account yet, e.g. using an email address.
     */
    case Unverified = 0;

    /**
     * The user has verified their account. The account is fully functional.
     */
    case Verified = 1;

    /**
     * The user's account has been suspended. They cannot log in or use the application.
     */
    case Suspended = 2;


    case Deleted = 3;

    /**
     * The user has elevated privileges, e.g. they are an administrator.
     */
    case Privileged = 4;


}