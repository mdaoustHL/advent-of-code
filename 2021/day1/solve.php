<?php
    /**
     * 2021 - Day 1
     * On a small screen, the sonar sweep report (your puzzle input) appears.
     * Each line is a measurement of the sea floor depth as the sweep looks further and further away from the submarine.
     * 
     * For example, suppose you had the following report:
     *      199
     *      200
     *      208
     *      210
     *      200
     *      207
     *      240
     *      269
     *      260
     *      263
     *
     * This report indicates that, scanning outward from the submarine, the sonar sweep found depths of 199, 200, 208, 210, and so on.
     *
     * The first order of business is to figure out how quickly the depth increases, just so you know what you're dealing with.
     * You never know if the keys will get carried into deeper water by an ocean current or a fish or something.
     *
     * To do this, count the number of times a depth measurement increases from the previous measurement. (There is no measurement before the first measurement.)
    **/

    require_once "../../common/php/functions.php";

    /**
     * Reads in the input.txt file and returns the data in an array.
     */
    function loadInput() {
        $data = [];

        if ($file = fopen('./input.txt', 'r')) {
            while (($line = fgets($file)) !== false) {
                array_push($data, intval($line));
            }
        }
        fclose($file);

        $dataPoints = sizeof($data);
        output("Input file loaded. ${dataPoints} datapoints loaded.", 1);

        return $data;
    }

    function countIncreases($dataPoints = []) {
        $increases = 0;

        for ($i = 1; $i < sizeof($dataPoints); $i++) {
            if ($dataPoints[$i] > $dataPoints[$i - 1]) {
                $increases++;
            }
        }

        return $increases;
    }

    /**
     * Entry point
     */
    function main() {
        welcome(1, 2021, "Depth Increase Detector");

        $depths = loadInput();
        $depthsCount = sizeof($depths);

        // Part 1
        $increases = countIncreases($depths);
        output("Part 1 Result: ${increases} increases detected.", 2);

        /**
         * Second part: Sum every 3 data points
         */
        $sliding3Sums = [];
        for ($i = 2; $i < $depthsCount; $i++) {
            $sum3 = $depths[$i] + $depths[$i - 1] + $depths[$i - 2];
            array_push($sliding3Sums, $sum3);
        }
        $sliding3SumsCount = sizeof($sliding3Sums);

        $sanityCheck = ($depthsCount - 2) === $sliding3SumsCount;
        if (!$sanityCheck) {
            output("Part 2 sanity check failling. Expected ${depthsCount} - 2 sums, got ${sliding3SumsCount} sums instead.", 1);
            die();
        }
        output("Part 2 Sanity check OK!", 1);

        // Part 2
        $increases = countIncreases($sliding3Sums);
        output("Part 2 Result: ${increases} increases detected.", 2);
    }

    // Start!
    main();
?>