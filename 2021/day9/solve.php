<?php
    require_once "../../common/php/functions.php";

    function loadInputData() {
        $data = [];

        if ($file = fopen('./input.txt', 'r')) {
            while (($line = fgets($file)) !== false) {
                $lineData = str_split(trim($line), 1);
                $lineData = array_map(function($n){return intval($n);}, $lineData);
                array_push($data, $lineData);
            }
        }
        fclose($file);

        $dataPoints = sizeof($data) * sizeof($data[0]);
        output("Input file loaded. ${dataPoints} datapoints loaded.", 2);

        return $data;
    }

    function main() {
        welcome(9, 2021, "Smoke Basin");

        $heightMap = loadInputData();
        $lowPoints = [];

        $rowCount = sizeof($heightMap);
        $colCount = sizeof($heightMap[0]);
        for ($row = 0; $row < $rowCount; $row++) {
            for ($col = 0; $col < $colCount; $col++) {
                $isLowPoint = true;
                // Compare left
                if ($col > 0) {
                    if ($heightMap[$row][$col] >= $heightMap[$row][$col - 1] ) {
                        $isLowPoint = false;
                    }
                }
                // Compare right
                if (($col + 1) < $colCount) {
                    if ($heightMap[$row][$col] >= $heightMap[$row][$col + 1] ) {
                        $isLowPoint = false;
                    }
                }
                // Compare up
                if ($row > 0) {
                    if ($heightMap[$row][$col] >= $heightMap[$row - 1][$col] ) {
                        $isLowPoint = false;
                    }
                }
                // Compare down
                if (($row + 1) < $rowCount) {
                    if ($heightMap[$row][$col] >= $heightMap[$row + 1][$col] ) {
                        $isLowPoint = false;
                    }
                }

                // Put it all together
                if ($isLowPoint) {
                    array_push($lowPoints, $heightMap[$row][$col]);
                }
            }
        }

        $risk = 0;
        foreach ($lowPoints as $lowPoint) {
            $risk += ($lowPoint + 1);
        }
        output("Part 1 Result: ${risk}", 2);
    }
    main();
?>