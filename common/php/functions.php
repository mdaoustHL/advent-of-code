<?php
    /**
     * Common PHP functions live here
     */

    function welcome($day, $year, $puzzleTitle) {
        output("Advent of Code ${year} - Day ${day}", 1);
        output("Puzzle: ${puzzleTitle}", 1);
        output("Let's go!", 2);
    }

    function output($string, $newlines = 0) {
        echo $string;
        while($newlines > 0) {
            echo "\r\n";
            $newlines--;
        }
    }

    /**
     * Reads in the input.txt file and returns the data in an array.
     */
    function loadInput() {
        $data = [];

        if ($file = fopen('./input.txt', 'r')) {
            while (($line = fgets($file)) !== false) {
                array_push($data, $line);
            }
        }
        fclose($file);

        $dataPoints = sizeof($data);
        output("Input file loaded. ${dataPoints} datapoints loaded.", 1);

        return $data;
    }
?>