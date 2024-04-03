<?php

namespace A11yBuddy\Frontend\Projects\ProjectDetails;

use A11yBuddy\Frontend\Localize;
use A11yBuddy\Frontend\View;
use A11yBuddy\User\SessionManager;
use A11yBuddy\User\User;
use Carbon\Carbon;

/**
 * Shows details of a project
 */
class ShowProjectDetailsView extends View
{

    public function render(array $data = []): void
    {
        /**
         * @var \A11yBuddy\Project\Project $project
         */
        $project = $data["project"];

        $workflows = $project->getWorkflows();
        ?>
        <h1>
            Project <i>
                <?= $project->getName() ?>
            </i>
        </h1>

        <p>
            <b>Description: </b>
            <?= $project->getDescription() ?>
        </p>

        <p>
            <b>Created at: </b>
            <?php
            $time = Carbon::createFromTimestamp($project->getCreatedAt());
            $time->locale(Localize::getInstance()->getLocale());
            echo $time->toDateString() . ", " . $time->diffForHumans();
            ?>
        </p>

        <p>
            <b>Last updated at: </b>
            <?php
            $time = Carbon::createFromTimestamp($project->getUpdatedAt());
            $time->locale(Localize::getInstance()->getLocale());
            echo $time . ", " . $time->diffForHumans();
            ?>

        <p>
            <b>Project Language: </b>
            <?= $project->getLanguage() ?>
        </p>

        <p>
            <b>Project Owner: </b>
            <?php
            $user = User::getById($project->getUserId());
            if ($user instanceof User) {
                echo '<a href="/profile/' . $user->getUsername() . '">' . $user->getDisplayName() . '</a>';
            } else {
                echo "Unknown";
            }
            ?>
        </p>

        <p>
            <b>Project Status: </b>
            <?= $project->getStatus()->name ?>
        </p>

        <?php
        if (empty($workflows)) {
            echo "<p>No workflows found</p>";
        } else {
            ?>
            <table class="table table-striped">
                <tr>
                    <?php
                    foreach (array_keys($workflows[0]) as $workflow) {
                        echo "<th>" . $workflow . "</th>";
                    }
                    ?>
                </tr>
                <?php
                foreach ($workflows as $workflow) {
                    echo "<tr>";
                    foreach ($workflow as $workflow) {
                        echo "<td>" . $workflow . "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </table>
            <?php
        }
        ?>

        <a href="/projects/<?= $project->getTextIdentifier() ?>/add" class="btn btn-primary">
            Add workflow
        </a>

        <?php
        if ($project->getUserId() === SessionManager::getLoggedInUserId()) {
            ?>
            <a href="/projects/<?= $project->getTextIdentifier() ?>/delete" class="btn btn-danger">
                Delete project
            </a>
            <?php
        }
    }

}