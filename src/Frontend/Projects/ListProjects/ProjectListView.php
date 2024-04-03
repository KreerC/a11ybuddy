<?php

namespace A11yBuddy\Frontend\Projects\ListProjects;

use A11yBuddy\Frontend\Localize;
use A11yBuddy\Frontend\View;
use Carbon\Carbon;

/**
 * Shows the list of projects supplied in $data["projects"]
 */
class ProjectListView extends View
{

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
                                                <?= $project["username"] ?>
                                                /
                                            </span>
                                            <?php
                                        }
                                        ?>
                                        <?= $project["name"] ?>
                                    </h2>
                                </a>
                                <p class="card-text">
                                    <?= $project["description"] ?>
                                </p>
                            </div>
                            <div class="card-footer">
                                <span class="text-muted">
                                    Last updated
                                    <?php $time = Carbon::createFromTimeString($project["updated_at"]);
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