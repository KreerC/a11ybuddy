<?php

namespace A11yBuddy\Frontend\Projects\ProjectDetails;

use A11yBuddy\Frontend\View;

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
            <?= $project->getName() ?>
        </h1>
        <h2>Project details</h2>
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

        <a href="/projects/<?= $project->getTextIdentifier() ?>/delete" class="btn btn-danger">
            Delete project
        </a>

        <?php
    }

}