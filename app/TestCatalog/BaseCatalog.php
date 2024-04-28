<?php

namespace App\TestCatalog;

class BaseCatalog
{

    public function __construct()
    {

        $this->name = __("Expert Review Catalog");

        $this->description = __("This catalog allows you to grade certain disability categories immediately.");

        $this->testQuestions = [
            [
                "question" => __("Is it accessible to blind screen reader users?"),
                "disabilitites" => [
                    "blind" => 1,
                    "low_vision" => 0.25,
                    "motor" => 0.5
                ]
            ],
            [
                "question" => __("Is it accessible to low vision users?"),
                "disabilitites" => [
                    "blind" => 0.5,
                    "low_vision" => 1,
                    "motor" => 0.25
                ]
            ],
            [
                "question" => __("Is it accessible to motor impaired users?"),
                "disabilitites" => [
                    "blind" => 0.5,
                    "motor" => 1
                ]
            ],
            [
                "question" => __("Is it accessible to deaf users?"),
                "disabilitites" => [
                    "deaf" => 1
                ]
            ],
            [
                "question" => __("Is it accessible to users with learning disabilities?"),
                "disabilitites" => [
                    "learning" => 1
                ]
            ],
            [
                "question" => __("Is it accessible to neurodiverse users (e.g. Autism/ADHD) ?"),
                "disabilitites" => [
                    "neurodiverse" => 1
                ]
            ]
        ];

    }

}