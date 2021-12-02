<?php
    // Day 2 - Part 1
    class SubmarineV1 {
        private $y = 0;
        private $depth = 0;

        function forward($units) {
            $this->y += $units;
        }

        function up($units) {
            $this->depth -= $units;
        }

        function down($units) {
            $this->depth += $units;
        }

        function getY() {
            return $this->y;
        }

        function getDepth() {
            return $this->depth;
        }
    }

    // Day 2 - Part 2
    class SubmarineV2 {
        private $y = 0;
        private $depth = 0;
        private $aim = 0;

        function forward($units) {
            $this->y += $units;
            $this->depth += ($this->aim * $units);
        }

        function up($units) {
            $this->aim -= $units;
        }

        function down($units) {
            $this->aim += $units;
        }

        function getAim() {
            return $this->aim;
        }

        function getY() {
            return $this->y;
        }

        function getDepth() {
            return $this->depth;
        }
    }
?>