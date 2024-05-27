<?php

class Sudoku
{
    const SUDOKU_ROWS = 9;
    const SUDOKU_COLUMNS = 9;
    const DEFAULT_MATRIX = [
        [0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0]
    ];
    public $sudoku;


    public function __construct(array $sudoku)
    {
        $this->sudoku = $sudoku;
    }


    public function solve(): bool
    {
        if (!$candidate = $this->getCandidatePosition()) {
            return true;
        }

        [$row, $column] = $candidate;

        for ($number = 1; $number < 10; $number++) {
            if ($this->isValidCandidate($number, $row, $column)) {
                $this->sudoku[$row][$column] = $number;

                if ($this->solve()) {
                    return true;
                }

                $this->sudoku[$row][$column] = 0;
            }
        }
        return false;
    }


    private function getCandidatePosition(): ?array
    {
        foreach ($this->sudoku as $row => $row_value) {
            foreach ($row_value as $col => $col_value) {
                if ($col_value == 0) {
                    return array($row, $col);
                }
            }
        }
        return [];
    }


    private function isValidCandidate(int $number, int $selected_row, int $selected_column): bool
    {

        // row validation
        foreach ($this->sudoku[$selected_row] as $index => $col) {
            if ($col == $number && $selected_column != $index) {
                return false;
            }
        }

        // column validation
        for ($index = 0; $index < self::SUDOKU_COLUMNS; $index++) {
            if ($this->sudoku[$index][$selected_column] == $number && $selected_row != $index) {
                return false;
            }
        }

        // box validation
        $box_y = intdiv($selected_row, 3) * 3;
        $box_x = intdiv($selected_column, 3) * 3;
        for ($i = $box_y; $i < $box_y + 3; $i++) {
            for ($j = $box_x; $j < $box_x + 3; $j++) {
                if ($this->sudoku[$i][$j] == $number && $i != $selected_row && $j != $selected_column) {
                    return false;
                }
            }
        }

        return true;
    }
}
