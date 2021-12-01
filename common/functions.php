<?php
    /**
     * Common functions live here
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
?>