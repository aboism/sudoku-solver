<?php

include "Sudoku.php";

$matrix = [];
for($row = 0; $row < Sudoku::SUDOKU_ROWS; $row++){
    for ($col = 0; $col < Sudoku::SUDOKU_COLUMNS; $col++){
        if(!isset($_POST[$row . $col]) || !is_numeric($_POST[$row . $col] == '' ? 0 : $_POST[$row . $col])){
            echo json_encode(Sudoku::DEFAULT_MATRIX);
            die();
        }
        $matrix[$row][$col] = (int)$_POST[$row . $col];
    }
}

$sudoku = new Sudoku($matrix);
$sudoku->solve();
echo json_encode($sudoku->sudoku);
