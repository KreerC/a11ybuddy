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
        if (isset ($data['error_message'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $data['error_message']; ?>
            </div>
            <?php
        }

        if (isset ($data['warning_message'])) {
            ?>
            <div class="alert alert-warning" role="alert">
                <?php echo $data['warning_message']; ?>
            </div>
            <?php
        }

        if (isset ($data['info_message'])) {
            ?>
            <div class="alert alert-info" role="alert">
                <?php echo $data['info_message']; ?>
            </div>
            <?php
        }
    }

}