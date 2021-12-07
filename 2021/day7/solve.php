<?php

    require_once "../../common/php/functions.php";

    function main() {
        welcome(7, 2021, "The Treachery of Whales");

        $crabs = explode(",", loadInput()[0]);
        $crabs = array_map(function($n){ return intval($n); }, $crabs);

        // Determine min/max
        $min = PHP_INT_MAX;
        $max = -1 * PHP_INT_MAX;
        foreach ($crabs as $crab) {
            if ($crab < $min) {
                $min = $crab;
            }
            if ($crab > $max) {
                $max = $crab;
            }
        }
        output("Min:Max values for crab position is ${min}:${max}", 1);

        // Itterate all possible positions, calculating the amount of fuel needed for each
        output("Calculating best position for Part 1...", 1);
        $fuelUsed = array_fill(0, $max - $min + 1, 0);
        for($i = $min; $i <= $max; $i++) {
            foreach ($crabs as $crab) {
                $fuel = abs($crab - $i);
                $fuelUsed[$i] += $fuel;
            }
        }

        // Result
        $bestPosition = -1;
        $bestFuelUse = PHP_INT_MAX;
        foreach ($fuelUsed as $position => $fuel) {
            if ($fuel < $bestFuelUse) {
                $bestFuelUse = $fuel;
                $bestPosition = $position;
            }
        }
        output("Part 1 Result: Best position is ${bestPosition} with fuel use of ${bestFuelUse}", 2);

        // Part 2
        // Itterate all possible positions, calculating the amount of fuel needed for each
        output("Calculating best position for Part 2...", 1);
        $fuelUsed = array_fill(0, $max - $min + 1, 0);
        for($i = $min; $i <= $max; $i++) {
            foreach ($crabs as $crab) {
                $diff = abs($crab - $i);
                $fuel = 0;
                for ($step=1; $step<=$diff; $step++) {
                    $fuel += $step;
                }
                $fuelUsed[$i] += $fuel;
            }
        }
        // Result
        $bestPosition = -1;
        $bestFuelUse = PHP_INT_MAX;
        foreach ($fuelUsed as $position => $fuel) {
            if ($fuel < $bestFuelUse) {
                $bestFuelUse = $fuel;
                $bestPosition = $position;
            }
        }
        output("Part 2 Result: Best position is ${bestPosition} with fuel use of ${bestFuelUse}", 2);
    }
    main();

?>