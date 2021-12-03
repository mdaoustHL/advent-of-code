<?php
    /**
     * --- Day 3: Binary Diagnostic ---
    * The submarine has been making some odd creaking noises, so you ask it to produce a diagnostic report just in case.
    * The diagnostic report (your puzzle input) consists of a list of binary numbers which, when decoded properly, can tell you many useful things about the conditions of the submarine.
    * The first parameter to check is the power consumption.
    *
    * You need to use the binary numbers in the diagnostic report to generate two new binary numbers (called the gamma rate and the epsilon rate).
    * The power consumption can then be found by multiplying the gamma rate by the epsilon rate.
    *
    * Each bit in the gamma rate can be determined by finding the most common bit in the corresponding position of all numbers in the diagnostic report.
    * For example, given the following diagnostic report:
    *     00100
    *     11110
    *     10110
    *     10111
    *     10101
    *     01111
    *     00111
    *     11100
    *     10000
    *     11001
    *     00010
    *     01010
    * Considering only the first bit of each number, there are five 0 bits and seven 1 bits. Since the most common bit is 1, the first bit of the gamma rate is 1.
    * The most common second bit of the numbers in the diagnostic report is 0, so the second bit of the gamma rate is 0.
    * The most common value of the third, fourth, and fifth bits are 1, 1, and 0, respectively, and so the final three bits of the gamma rate are 110.
    * So, the gamma rate is the binary number 10110, or 22 in decimal.
    * 
    * The epsilon rate is calculated in a similar way; rather than use the most common bit, the least common bit from each position is used.
    * So, the epsilon rate is 01001, or 9 in decimal. Multiplying the gamma rate (22) by the epsilon rate (9) produces the power consumption, 198.
    *
    * Use the binary numbers in your diagnostic report to calculate the gamma rate and epsilon rate, then multiply them together.
    * What is the power consumption of the submarine?
    */

    require_once "../../common/php/functions.php";

    function binaryOneCount($data) {
        $length = strlen($data[0]);
        $oneCount = array_fill(0, $length - 1, 0);
        foreach ($data as $dataPoint) {
            for ($i = 0; $i < $length; $i++) {
                $char = substr($dataPoint, $i, 1);
                if ($char === '1') {
                    $oneCount[$i] += 1;
                }
            }
        }
        return $oneCount;
    }

    function gammaEpsCalc($data) {
        $oneCount = binaryOneCount($data);
        $gamma = "";
        $eps = "";
        foreach ($oneCount as $bitCount) {
            if ($bitCount > (sizeof($data)/2)) {
                $gamma .= "1";
                $eps .= "0";
            } else if ($bitCount === (sizeof($data)/2)) {
                $gamma .= "1";
                $eps .= "0";
            } else {
                $gamma .= "0";
                $eps .= "1";
            }
        }
        return array("gamma" => $gamma, "epsilon" => $eps);
    }

     /**
     * Entry point
     */
    function main() {
        welcome(3, 2021, "Binary Diagnostic");

        $dataPoints = loadInput();
        $dataPointCount = sizeof($dataPoints);
        $binaryLength = strlen($dataPoints[0]);

        // Process Gamma & eps
        $gammaEps = gammaEpsCalc($dataPoints);
        $gamma = $gammaEps["gamma"];
        $eps = $gammaEps["epsilon"];    

        output("Gamma: ${gamma} Epsilon: ${eps}", 1);

        $gammaDec = bindec($gamma);
        $epsDec = bindec($eps);
        $result = $gammaDec * $epsDec;

        output("Gamma: ${gammaDec} Epsilon: ${epsDec}", 1);
        output("Part 1 Result: ${result}", 2);

        // Part 2
        $oxygenGeneratorData = array_values(array_filter($dataPoints, function($v) use ($gamma) { return (substr($v, 0, 1) === substr($gamma, 0, 1)); }));
        $co2ScrubberData = array_values(array_filter($dataPoints, function($v) use ($eps) { return (substr($v, 0, 1) === substr($eps, 0, 1)); }));
        // Sanity check
        if ((sizeof($oxygenGeneratorData) + sizeof($co2ScrubberData)) === $dataPointCount) {
            output("Part 2 sanity check OK!", 1);
        } else {
            output("Part 2 sanity check FAILED!", 1);
            die();
        }

        // Process part 2
        for($bitPosition = 1; $bitPosition < $binaryLength; $bitPosition++) {
            if (sizeof($oxygenGeneratorData) > 1) {
                $o2 = gammaEpsCalc($oxygenGeneratorData)["gamma"];
                $o2BitCrit = substr($o2, $bitPosition, 1);
                $oxygenGeneratorData = array_values(array_filter($oxygenGeneratorData, function ($v) use ($o2BitCrit, $bitPosition) {
                    return (substr($v, $bitPosition, 1) === $o2BitCrit);
                }));
            }
            if (sizeof($co2ScrubberData) > 1) {
                $co2 = gammaEpsCalc($co2ScrubberData)["epsilon"];
                $co2BitCrit = substr($co2, $bitPosition, 1);
                $co2ScrubberData = array_values(array_filter($co2ScrubberData, function ($v) use ($co2BitCrit, $bitPosition) {
                    return (substr($v, $bitPosition, 1) === $co2BitCrit);
                }));
            }
        }

        $oxygenGeneratorRating = $oxygenGeneratorData[0];
        $oxygenGeneratorRatingDec = bindec($oxygenGeneratorRating);
        $co2ScrubberRating = $co2ScrubberData[0];
        $co2ScrubberRatingDec = bindec($co2ScrubberRating);
        $result = $oxygenGeneratorRatingDec * $co2ScrubberRatingDec;

        output("Oxygen Generator Rating: ${oxygenGeneratorRating}");
        output("Oxygen Generator Rating (decimal): ${oxygenGeneratorRatingDec}", 1);
        output("CO2 Scrubber Rating: ${co2ScrubberRating}");
        output("CO2 Scrubber Rating (decimal): ${co2ScrubberRatingDec}", 2);
        output("Part 2 Result: ${result}", 1);
    }
    main();

?>