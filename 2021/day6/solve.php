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

    function simulate($aquarium, $days) {
        output("Simulating ${days} days...", 1);

        for ($day = 1; $day <= $days; $day++) {
            $currentAquariumSize = sizeof($aquarium);
            for ($f = 0; $f < $currentAquariumSize; $f++) {
                $aquarium[$f] -= 1;
                if ($aquarium[$f] < 0) {
                    $aquarium[$f] = 6;
                    array_push($aquarium, 8);
                }
            }
            $count = sizeof($aquarium);
            $diff = $count - $currentAquariumSize;
            output("Day ${day} => Started at ${currentAquariumSize}, ended at ${count}. Growth of ${diff}", 1);
        }

        return $aquarium;
    }

    require_once "../../common/php/functions.php";

    function main() {
        welcome(6, 2021, "Lanternfish");

        // Part 1
        $aquarium = loadAquarium();
        $aquarium = simulate($aquarium, 80);
        $part1Result = sizeof($aquarium);
        output("Part 1 Result: ${part1Result} fish after 80 days.", 2);

        // Part 2
        $aquarium = loadAquarium();
        ini_set("memory_limit", "16000000000"); // 16GB - Doesn't work, script still requires too much memory => OOM error
        $aquarium = simulate($aquarium, 256);
        $part2Result = sizeof($aquarium);
        output("Part 2 Result: ${part2Result} fish after 256 days.", 2); // If you can get here, congrats! I haven't lol
        // The farthest I've gotten is Day 155 @ 261,566,169 lanterfish before OOM error occurs
    }
    main();

?>