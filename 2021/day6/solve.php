<?php

    function loadAquarium() {
        $aquarium = explode(",", loadInput()[0]);
        $aquarium = array_map(function($n){
            return intval($n);
        }, $aquarium);
        $fishCount = sizeof($aquarium);
        output("We have ${fishCount} fish in the aquarium.", 2);
        return $aquarium;
    }

    require_once "../../common/php/functions.php";

    function main() {
        welcome(6, 2021, "Lanternfish");

        $aquarium = loadAquarium();

        // Part 1
        output("Simulating 80 days...", 1);

        for ($day = 1; $day <= 80; $day++) {
            $new = [];
            for ($f = 0; $f < sizeof($aquarium); $f++) {
                $aquarium[$f] -= 1;
                if ($aquarium[$f] < 0) {
                    $aquarium[$f] = 6;
                    array_push($new, 8);
                }
            }
            // Add the newly spawned fish to aquarium
            $aquarium = array_values(array_merge($aquarium, $new));
            $count = sizeof($aquarium);
            output("Day ${day} => ${count}", 1);
        }

        $part1Result = sizeof($aquarium);
        output("Part 1 Result: ${part1Result} fish after 80 days.", 2);

        // Part 2
        $aquarium = loadAquarium(); ini_set("memory_limit", "14000000000"); // 12GB
        output("Simulating 256 days...", 1);

        for ($day = 1; $day <=256; $day++) {
            $new = [];
            for ($f = 0; $f < sizeof($aquarium); $f++) {
                $aquarium[$f] -= 1;
                if ($aquarium[$f] < 0) {
                    $aquarium[$f] = 6;
                    array_push($new, 8);
                }
            }
            // Add the newly spawned fish to aquarium
            $aquarium = array_values(array_merge($aquarium, $new));
            $count = sizeof($aquarium);
            output("Day ${day} => ${count}", 1);
        }

        $part1Result = sizeof($aquarium);
        output("Part 2 Result: ${part1Result} fish after 80 days.", 2);

    }
    main();

?>