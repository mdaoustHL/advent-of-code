<?php

    class BingoBoard {
        private $lines;
        private $marked;
        private $winIndex;
        private $winNumber;

        function __construct($lines) {
            $this->lines = $lines;
            $this->reset();

            // Sanity checks
            if (sizeof($this->lines) !== 5) {
                print_r($this);
                die("Expected Line count mismatch. Bad board data!");
            }
            foreach ($this->lines as $line) {
                if (sizeof($line) !== 5) {
                    print_r($this);
                    die("Expected Line Data mismatch. Bad board data!");
                }
            }
        }

        function reset() {
            $this->marked = [
                array_fill(0, 5, false),
                array_fill(0, 5, false),
                array_fill(0, 5, false),
                array_fill(0, 5, false),
                array_fill(0, 5, false),
            ];
            $this->winIndex = -1;
            $this->winNumber = -1;
        }

        function getWinData() {
            return [
                'index' => $this->winIndex,
                'number' => $this->winNumber
            ];
        }

        function markAndCheck($num, $i = 0) {
            if ($this->winIndex === -1) {
                $this->mark($num);
                $win = $this->checkWin();
                if ($win) {
                    $this->winIndex = $i;
                    $this->winNumber = $num;
                }
                return $win;
            }
        }

        function mark($num) {
            $found = false;
            for ($r = 0; $r < 5; $r++) {
                for ($c = 0; $c < 5; $c++) {
                    if (intval($this->lines[$r][$c]) === $num) {
                        $this->marked[$r][$c] = true;
                        $found = true;
                        break;
                    }
                }
                if ($found) {
                    break;
                }
            }
        }

        function checkWin() {
            // Rows
            for ($r = 0; $r < 5; $r++) {
                if ($this->marked[$r][0] && $this->marked[$r][1] && $this->marked[$r][2] && $this->marked[$r][3] && $this->marked[$r][4]) {
                    return true;
                }
            }
            // Columns
            for ($c = 0; $c < 5; $c++) {
                if ($this->marked[0][$c] && $this->marked[1][$c] && $this->marked[2][$c] && $this->marked[3][$c] && $this->marked[4][$c]) {
                    return true;
                }
            }

            return false;
        }

        function score() {
            if ($this->winIndex === -1 || $this->winNumber === -1) {
                return 0;
            }

            $score = 0;
            for ($r = 0; $r < 5; $r++) {
                for ($c = 0; $c < 5; $c++) {
                    if (!$this->marked[$r][$c]) {
                        $score += intval(trim($this->lines[$r][$c]));
                    }
                }
            }
            return $score * $this->winNumber;
        }
    }

    function loadBingoData() {
        $numbers = [];
        $boards = [];

        $i = 0;
        $boardData = [];
        if ($file = fopen('./input.txt', 'r')) {
            while (($line = fgets($file)) !== false) {
                if ($i === 0) {
                    $numbers = explode(",", $line);
                } else {
                    $l = preg_replace('/\s\s+/', " ", trim($line));
                    if ($l === "" && $i > 1) {
                        array_push($boards, new BingoBoard($boardData));
                        $boardData = [];
                    } else if ($l !== "") {
                        array_push($boardData, explode(" ", $l));
                    }
                }
                $i++;
            }
            if (!empty($boardData)) {
                array_push($boards, new BingoBoard($boardData));
            }
        }
        fclose($file);

        $boardCount = sizeof($boards);
        output("Input file loaded. ${boardCount} bingo boards loaded.", 2);

        return [
            "numbers" => array_values($numbers),
            "boards" => array_values($boards)
        ];
    }

    require_once "../../common/php/functions.php";

    function main() {
        welcome(4, 2021, "Giant Squid");

        $bingoData = loadBingoData();

        $bingoNumbers = $bingoData["numbers"];
        $bingoBoards = $bingoData["boards"];

        $winningBoard = null;
        $winDex = 0; // Win index
        foreach ($bingoNumbers as $bingoNumber) {
            foreach ($bingoBoards as $bingoBoard) {
                if ($bingoBoard->markAndCheck(intval(trim($bingoNumber)), $winDex)) {
                    $winningBoard = $bingoBoard;
                    $winDex++;
                    break;
                }
            }
            if (isset($winningBoard)) {
                break;
            }
        }

        // Part 1 Result!
        if (isset($winningBoard)) {
            $score = $winningBoard->score();
            output("Bingo! We have the first winner!", 1);
            output("Score is ${score}", 2);
        }

        // Part 2
        // Reset
        $winningBoard = null;
        foreach ($bingoBoards as $bingoBoard) {
            $bingoBoard->reset();
        }

        $winDex = 0;
        foreach ($bingoNumbers as $bingoNumber) {
            $bingoBoards = array_values($bingoBoards);
            for ($i = 0; $i < sizeof($bingoBoards); $i++) {
                $bingoBoard = $bingoBoards[$i];
                if ($bingoBoard->markAndCheck(intval(trim($bingoNumber)), $winDex)) {
                    $winDex++;
                }
            }
            $i++;
        }

        // Part 2 Result!
        $last = -1;
        $lastWinningBoard = null;
        foreach ($bingoBoards as $bingoBoard) {
            $win = $bingoBoard->getWinData();
            if (isset($win)) {
                if ($win["index"] > $last) {
                    $last = $win["index"];
                    $lastWinningBoard = $bingoBoard;
                }
            } else {
                die("Error: One of the boards did not even win!");
            }
        }

        if (isset($lastWinningBoard)) {
            $finalScore = $lastWinningBoard->score();
            output("Bingo! We have a final winner!", 1);
            output("Score is ${finalScore}", 1);
        }

        //print_r($lastWinningBoard);

    }
    main();

?>