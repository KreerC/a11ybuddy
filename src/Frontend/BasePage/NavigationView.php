<?php

namespace A11yBuddy\Frontend\BasePage;

use A11yBuddy\Application;
use A11yBuddy\Frontend\Localize;
use A11yBuddy\Frontend\View;
use A11yBuddy\Router;

/**
 * Renders the topmost navbar
 */
class NavigationView extends View
{

    public function render(array $data = []): void
    {
        SkipLinkView::use();
        ?>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <?= Application::getInstance()->getConfig()["app"]["name"]; ?>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false"
                    aria-label="<?= Localize::translate("toggle_navigation", "Toggle Navigation") ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <?php

                        $nav = [
                            "/discover" => "Discover"
                        ];

                        foreach ($nav as $route => $label) {
                            $this->renderBasicNavigationItem($route, $label);
                        }

                        ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <?= Localize::translate("account", "Account") ?>
                            </a>

                            <?php
                            if (!Application::getInstance()->getSessionManager()->isLoggedIn()) {
                                ?>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/login">
                                            <?= Localize::translate("login", "Log In") ?>
                                        </a></li>
                                    <li><a class="dropdown-item" href="/signup">
                                            <?= Localize::translate("signup", "Sign Up") ?>
                                        </a></li>
                                </ul>
                                <?php
                            } else {
                                ?>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/projects">
                                            <?= Localize::translate("my-projects", "My projects") ?>
                                        </a></li>
                                    <li><a class="dropdown-item" href="/logout">
                                            <?= Localize::translate("logout", "Log Out") ?>
                                        </a></li>
                                </ul>
                                <?php
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php
    }

    private function renderBasicNavigationItem(string $route, string $label): void
    {
        ?>
        <li class="nav-item">
            <a class="nav-link<?= Router::getRequestUri() === $route ? ' active " aria-current="page' : '' ?>"
                href="<?= $route ?>">
                <?= Localize::translate(trim($route, "/"), $label) ?>
            </a>
        </li>
        <?php
    }

}