<?php

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Frontend\View;

/**
 * Can display error, warning and info messages if they are set in the data array
 */
class ErrorView extends View
{

    public function render(array $data = []): void
    {
        if (isset($data['error_message'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                <span aria-hidden="true" class="mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill"
                        viewBox="0 0 16 16">
                        <path
                            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708" />
                    </svg>
                </span>
                <?= $data['error_message']; ?>
            </div>
            <?php
        }

        if (isset($data['warning_message'])) {
            ?>
            <div class="alert alert-warning" role="alert">
                <span aria-hidden="true" class="mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path
                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                    </svg>
                </span>
                <?= $data['warning_message']; ?>
            </div>
            <?php
        }

        if (isset($data['info_message'])) {
            ?>
            <div class="alert alert-info" role="alert">
                <span aria-hidden="true" class="mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
                    </svg>
                </span>
                <?= $data['info_message']; ?>
            </div>
            <?php
        }

        if (isset($data["success_message"])) {
            ?>
            <div class="alert alert-success" role="alert">
                <span aria-hidden="true" class="mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                </span>
                <?= $data["success_message"]; ?>
            </div>
            <?php
        }
    }

}