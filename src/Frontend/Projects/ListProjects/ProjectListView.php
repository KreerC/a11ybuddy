<?php

namespace A11yBuddy\Frontend\Projects\ListProjects;

use A11yBuddy\Frontend\Localize;
use A11yBuddy\Frontend\View;
use A11yBuddy\Project\ProjectStatus;
use Carbon\Carbon;

/**
 * Shows the list of projects supplied in $data["projects"]
 */
class ProjectListView extends View
{

    /**
     * Renders the list of projects
     * This view DOES NOT expect Project objects, but an array of projects directly from the database.
     */
    public function render(array $data = []): void
    {
        $projects = $data["projects"] ?? [];

        ?>
        <?php
        if (empty($projects)) {
            echo "<p><b>No projects found</p></b>";
        } else {
            ?>
            <div class="row">
                <?php
                foreach ($projects as $project) {
                    ?>
                    <div class="col-lg-12">
                        <div class="card mb-3" lang="<?= $project["language"] ?>">
                            <div class="card-body">
                                <a href="/projects/<?= $project["text_identifier"] ?>">
                                    <h2 class="card-title">
                                        <?php
                                        if (isset($project["username"])) {
                                            ?>
                                            <span class="text-muted">
                                                <?= htmlentities($project["username"]) ?>
                                                /
                                            </span>
                                            <?php
                                        }

                                        echo htmlentities($project["name"]);

                                        ?>
                                    </h2>
                                </a>
                                <?php
                                if ($project["status"] != 0) {
                                    ?>
                                    <span class="badge text-bg-secondary">
                                        <?php
                                        $status = ProjectStatus::tryFrom($project["status"]);
                                        if ($status !== null) {
                                            echo $status->name;
                                        } else {
                                            echo "Unknown";
                                        }
                                        ?>
                                    </span>
                                    <?php
                                }
                                ?>
                                <p class="card-text">
                                    <?= htmlentities($project["description"]) ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <span class="text-muted">
                                    Last updated
                                    <?php $time = Carbon::createFromTimeString($project["updated_at"], "Europe/Berlin");
                                    $time->locale(Localize::getInstance()->getLocale());
                                    echo $time->diffForHumans(); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
    }
}