<?php
    /**
     * 2021 - Day 2
     * 
     * Now, you need to figure out how to pilot this thing. It seems like the submarine can take a series of commands like forward 1, down 2, or up 3:
     *      forward X increases the horizontal position by X units.
     *      down X increases the depth by X units.
     *      up X decreases the depth by X units.
     *      Note that since you're on a submarine, down and up affect your depth, and so they have the opposite result of what you might expect.
     *
     * The submarine seems to already have a planned course (your puzzle input). You should probably figure out where it's going.
     * Your horizontal position and depth both start at 0.
     * 
     * Calculate the horizontal position and depth you would have after following the planned course.
     * What do you get if you multiply your final horizontal position by your final depth?
     */

    require_once "../../common/php/functions.php";
    require_once "../common/Submarine.php";

    /**
     * Entry point
     */
    function main() {
        welcome(2, 2021, "Dive! Dive! Dive! Maneuvering the Submarine.");

        // Load the commands
        $commands = loadInput();

        // Create the sub
        $sub = new SubmarineV1();

        // Process the commands
        foreach ($commands as $command) {
            $commandSet = explode(" ", $command);
            $inst = $commandSet[0];
            $units = intval($commandSet[1]);
            $sub->$inst($units);
        }

        // Get the results for Part 1
        $y = $sub->getY();
        $depth = $sub->getDepth();
        $part1Result = $y * $depth;
        output("Part 1 Result: SubmarineV1 is at horizontal position ${y} with a depth of ${depth}. Multiplied together => ${part1Result}", 1);

        // Part 2 - Use the better submarine
        $sub = new SubmarineV2();

        // Process the commands
        foreach ($commands as $command) {
            $commandSet = explode(" ", $command);
            $inst = $commandSet[0];
            $units = intval($commandSet[1]);
            $sub->$inst($units);
        }

        // Get the results for Part 2
        $y = $sub->getY();
        $depth = $sub->getDepth();
        $part1Result = $y * $depth;
        output("Part 2 Result: SubmarineV2 is at horizontal position ${y} with a depth of ${depth}. Multiplied together => ${part1Result}", 2);
    }

    main();
?>