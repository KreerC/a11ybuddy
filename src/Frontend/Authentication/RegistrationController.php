<?php

namespace A11yBuddy\Frontend\Authentication;

use A11yBuddy\Frontend\Controller;
use A11yBuddy\User\User;

class RegistrationController extends Controller
{

    public function run(array $data = []): void
    {
        if (
            isset ($_POST['username']) &&
            isset ($_POST['email']) &&
            isset ($_POST['display_name']) &&
            isset ($_POST['password']) &&
            isset ($_POST['password_confirm'])
        ) {
            $data['post'] = $_POST;
            $user = new User([]);
            $result = $user->setUsername($_POST['username']);

            if ($result !== true) {
                $data['error_message'] = "Invalid username. It might already be taken.";
                RegistrationFormView::use($data);
                return;
            }

            $result = $user->setEmail($_POST['email']);

            if ($result !== true) {
                $data['error_message'] = "Invalid e-mail address. It might already be taken or does not match the required format of mail@example.com.";
                RegistrationFormView::use($data);
                return;
            }

            $result = $user->setDisplayName($_POST['display_name']);

            if ($result !== true) {
                $data['error_message'] = "Invalid display name. It might already be taken.";
                RegistrationFormView::use($data);
                return;
            }

            if ($_POST['password'] !== $_POST['password_confirm']) {
                $data['error_message'] = "The password confirmation does not match with your desired password.";
                RegistrationFormView::use($data);
                return;
            }

            $result = $user->setPassword($_POST['password']);

            if ($result !== true) {
                $data['error_message'] = "Invalid password. It must be at least 8 characters long.";
                RegistrationFormView::use($data);
                return;
            }

            $result = $user->save();

            // TODO Send verification e-mail

            if ($result !== true) {
                $data['error_message'] = "An error occurred while saving your account. Please try again.";
                RegistrationFormView::use($data);
            } else {
                // TODO show a proper view instead
                $data['info_message'] = "Your account has been created. Please check your e-mail for a verification link. The link will expire in 24 hours.";
                RegistrationFormView::use($data);
            }

            return;
        } else {
            RegistrationFormView::use($data);
        }
    }

}