<?php

namespace A11yBuddy\Frontend\Projects\ListProjects;

use A11yBuddy\Frontend\View;

/**
 * Shows the list of projects supplied.
 */
class ShowListOfUserProjectsView extends View
{

    // TODO this works for any user, but right now it's only used for the logged in user
    public function render(array $data = []): void
    {
        $projects = $data["projects"];
        ?>
        <h1>
            Your projects
        </h1>
        <table class="table table-striped">
            <tr>
                <?php
                foreach (array_keys($projects[0]) as $project) {
                    echo "<th>" . $project . "</th>";
                }
                ?>
            </tr>
            <?php
            foreach ($projects as $project) {
                echo "<tr>";
                foreach ($project as $key => $project) {

                    if ($key === "text_identifier") {
                        echo "<td><a href='/projects/" . $project . "'>" . $project . "</a></td>";
                        continue;
                    }

                    echo "<td>" . $project . "</td>";

                }
                echo "</tr>";
            }
            ?>
        </table>
        <?php
    }
}