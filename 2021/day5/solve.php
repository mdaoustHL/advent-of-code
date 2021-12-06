<?php

    class Point {
        public $x;
        public $y;

        function __construct($x, $y) {
            $this->x = intval($x);
            $this->y = intval($y);
        }

        function getHash() {
            return sha1($this->x.",".$this->y);
        }
    }

    class LineSegment {
        private Point $start;
        private Point $end;

        function __construct(Point $start, Point $end) {
            $this->start = $start;
            $this->end = $end;
        }

        function isVertical() : bool {
            return $this->start->x === $this->end->x;
        }

        function isHorizontal() : bool {
            return $this->start->y === $this->end->y;
        }

        // True (+1) means LTR===>, while false (-1) means RTL<===
        function getHorizontalDirection() {
            $dir = $this->start->x > $this->end->x;
            if ($dir) {
                return 1; // LTR
            } else {
                return -1; // RTL
            }
        }

        // True (+1) means BTT (up), while false (-1) means TTB (down)
        function getVerticalDirection() {
            $dir = $this->start->y > $this->end->y;
            if ($dir) {
                return -1;
            } else {
                return 1;
            }
        }

        function getAllPoints() : array {
            $points = [$this->start, $this->end]; // pre-load start/end points

            if ($this->isHorizontal()) {
                // Y is fixed
                $y = $this->start->y;

                // Determine line direction
                $dir = $this->getHorizontalDirection();

                // Count how many points we have on the line segment (excluding the start/end points)
                $pointCount = abs($this->start->x - $this->end->x) - 1;

                // Add the points
                for ($i = 1; $i <= $pointCount; $i++) {
                    $x = $this->start->x - ($i * $dir);
                    $p = new Point($x, $y);
                    array_push($points, $p);
                }
            } else if ($this->isVertical()) {
                // X is fixed
                $x = $this->start->x;
                
                // Determine line direction
                $dir = $this->getVerticalDirection();

                // Count how many points we have on the line segment (excluding the start/end points)
                $pointCount = abs($this->start->y - $this->end->y) - 1;

                // Add the points
                for ($i = 1; $i <= $pointCount; $i++) {
                    $y = $this->start->y + ($i * $dir);
                    $p = new Point($x, $y);
                    array_push($points, $p);
                }
            } else {
                $dirVert = $this->getVerticalDirection();
                $dirHorz = $this->getHorizontalDirection();
                
                $nextX = $this->start->x - $dirHorz;
                $nextY = $this->start->y + $dirVert;

                while (
                    $nextX != $this->end->x &&
                    $nextY != $this->end->y
                ) {
                    $p = new Point($nextX, $nextY);
                    array_push($points, $p);
                    $nextX -= $dirHorz;
                    $nextY += $dirVert;
                }
            }

            return $points;
        }
    }

    function loadLineSegments() {
        $lineSegments = [];

        if ($file = fopen('./input.txt', 'r')) {
            while (($line = fgets($file)) !== false) {
                $lineData = explode("->", $line);
                $p1Data = explode(",", $lineData[0]);
                $p2Data = explode(",", $lineData[1]);

                $lineSegment = new LineSegment(
                    new Point($p1Data[0], $p1Data[1]),
                    new Point($p2Data[0], $p2Data[1])
                );
                array_push($lineSegments, $lineSegment);
            }
        }
        fclose($file);

        $lineSegmentCount = sizeof($lineSegments);
        output("Input file loaded. ${lineSegmentCount} line segments loaded.", 2);

        return $lineSegments;
    }

    require_once "../../common/php/functions.php";

    function main() {
        welcome(5, 2021, "Hydrothermal Venture");

        $lines = loadLineSegments();

        // Part 1 - Filter out non horizontal/vertical lines
        $part1Lines = array_values(array_filter($lines, function (LineSegment $v) {
            return ($v->isVertical() || $v->isHorizontal());
        }));
        $part1LineCount = sizeof($part1Lines);

        // Get all the points
        $points = [];
        foreach ($part1Lines as $line) {
            $points = array_merge($points, $line->getAllPoints());
        }
        $points = array_values($points);
        $pointCount = sizeof($points);
        output("Part 1 has ${part1LineCount} line segments with a total of ${pointCount} points.", 1);

        // Process all these points to find duplicates
        $dupes = [];
        foreach ($points as $point) {
            $hash = $point->getHash();
            if (isset($dupes[$hash])) {
                $dupes[$hash] += 1;
            } else {
                $dupes[$hash] = 1;
            }
        }
        $dupes = array_filter($dupes, function($v) {
            return $v > 1;
        });
        $part1Result = sizeof($dupes);
        output("Part 1 Results: ${part1Result}", 2);

        // Part 2
        // Get all the points
        $points = [];
        foreach ($lines as $line) {
            $points = array_merge($points, $line->getAllPoints());
        }
        $points = array_values($points);
        $pointCount = sizeof($points);
        $lineCount = sizeof($lines);
        output("Part 2 has ${lineCount} line segments with a total of ${pointCount} points.", 1);
        //print_r($points); die();

        // Process all these points to find duplicates
        $dupes = [];
        foreach ($points as $point) {
            $hash = $point->getHash();
            if (isset($dupes[$hash])) {
                $dupes[$hash] += 1;
            } else {
                $dupes[$hash] = 1;
            }
        }
        $dupes = array_filter($dupes, function($v) {
            return $v > 1;
        });
        $part2Result = sizeof($dupes);
        output("Part 2 Results: ${part2Result}", 2); // 7339 too low

    }
    main();

?>