<?php

namespace A11yBuddy\Frontend\Projects;

use A11yBuddy\Frontend\View;

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
        <p>
            This is where the details of the project will be displayed.
            <?php
            // Echo the keys as a table heading
            echo "<table>";
            echo "<tr>";
            foreach (array_keys($workflows[0]) as $workflow) {
                echo "<th>" . $workflow . "</th>";
            }
            echo "</tr>";
            foreach ($workflows as $workflow) {
                echo "<tr>";
                foreach ($workflow as $workflow) {
                    echo "<td>" . $workflow . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            ?>
        </p>
        <?php
    }

}