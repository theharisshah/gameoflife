<?php

const SIZE = 25;


function createGrid() {
    $grid = [];
    for ($i = 0; $i < SIZE; $i++) {
        for ($j = 0; $j < SIZE; $j++) {
            $grid[$i][$j] = 0; 
        }
    }
    return $grid;
}


function addPattern(&$grid) {
    $mid = (int) SIZE/2; 

    $glider = [
        [0, 1, 0],
        [0, 0, 1],
        [1, 1, 1]
    ];

    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            $grid[$mid - 1 + $i][$mid - 1 + $j] = $glider[$i][$j];
        }
    }
}


function generateGeneration($grid) {
    echo "\n";
    foreach ($grid as $row) {
        foreach ($row as $cell) {
            echo $cell ? "■ " : "□ ";
        }
        echo "\n";
    }
}


function totalAliveNeighbors($grid, $x, $y) {
    $neighbors = [
        [-1, -1], [-1, 0], [-1, 1],
        [0, -1],          [0, 1],
        [1, -1], [1, 0], [1, 1]
    ];
    $count = 0;

    foreach ($neighbors as [$dx, $dy]) {
        $nx = $x + $dx;
        $ny = $y + $dy;
        if ($nx >= 0 && $nx < SIZE && $ny >= 0 && $ny < SIZE && $grid[$nx][$ny] == 1) {
            $count++;
        }
    }
    return $count;
}


function moveGeneration($grid) {
    $newGrid = createGrid();
    
    for ($i = 0; $i < SIZE; $i++) {
        for ($j = 0; $j < SIZE; $j++) {
            $liveNeighbors = totalAliveNeighbors($grid, $i, $j);

            if ($grid[$i][$j] == 1) {
                $newGrid[$i][$j] = ($liveNeighbors == 2 || $liveNeighbors == 3) ? 1 : 0;
            } else {
                $newGrid[$i][$j] = ($liveNeighbors == 3) ? 1 : 0;
            }
        }
    }
    return $newGrid;
}

$grid = createGrid();
addPattern($grid);
generateGeneration($grid);

echo "Enter the number of generations: ";
$generations = (int) readline();

for ($gen = 1; $gen <= $generations; $gen++) {
    sleep(1); 
    $grid = moveGeneration($grid);
    echo "Generation $gen:\n";
    generateGeneration($grid);
}
?>
