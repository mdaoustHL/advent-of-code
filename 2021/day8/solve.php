<?php

    require_once "../../common/php/functions.php";

    class DataEntry {
        public $signalPatterns;
        public $outputValues;

        function __construct($signalPatterns, $outputValues) {
            $this->signalPatterns = $signalPatterns;
            $this->outputValues = $outputValues;
        }
    }

    function main() {
        welcome(8, 2021, "Seven Segment Search");

        $segmentCounts = [
            0 => 6,
            1 => 2,
            2 => 5,
            3 => 5,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 3,
            8 => 7,
            9 => 6
        ];

        $inputData = loadInput();

        // Parse out the data collection
        $dataCollection = [];
        foreach ($inputData as $data) {
            $splitData = explode(" | ", $data);
            $signalPatterns = explode(" ", trim($splitData[0]));
            $outputValues = explode(" ", trim($splitData[1]));

            $dataEntry = new DataEntry($signalPatterns, $outputValues);
            array_push($dataCollection, $dataEntry);
        }

        // Count all 1, 4, 7 and 8's in the output values based on the segment count
        $counts = [
            1 => 0,
            4 => 0,
            7 => 0,
            8 => 0
        ];
        foreach ($dataCollection as $dataEntry) {
            foreach ($dataEntry->outputValues as $outputValue) {
                $outputValueLength = strlen($outputValue);
                foreach ([1,4,7,8] as $number) {
                    if ($outputValueLength == $segmentCounts[$number]) {
                        // This output value is $number
                        $counts[$number] += 1;
                    }
                }
            }
        }

        output("Part 1 results:", 1);
        print_r($counts);
        $sum = 0;
        foreach ($counts as $count) {
            $sum += $count;
        }
        output("Sum: ${sum}", 2);
        
    }
    main();

?>