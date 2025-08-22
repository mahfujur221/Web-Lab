<?php
function findGCD($a, $b) {
    while ($b != 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    return $a;
}

function getNthLargestGCDValue($arr, $position) {
    if (count($arr) > 6) {
        return "Error: The number of elements should not exceed 6.";
    }

    $gcdList = [];
    
    for ($i = 0; $i < count($arr); $i++) {
        for ($j = $i + 1; $j < count($arr); $j++) {
            $gcdList[] = findGCD($arr[$i], $arr[$j]);
        }
    }

    rsort($gcdList);  

    if ($position > 0 && $position <= count($gcdList)) {
        return $gcdList[$position - 1]; 
    } else {
        return "Error: The position is out of range.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputNumbers = explode(" ", $_POST["numbers"]); 
    $position = intval($_POST["n"]); 

    foreach ($inputNumbers as $num) {
        if (!is_numeric($num)) {
            $error = "Error: Please enter only valid numbers.";
            break;
        }
    }

    if (!isset($error)) {
        $result = getNthLargestGCDValue($inputNumbers, $position);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find nth Largest GCD</title>
</head>
<body>

<h2>Find the nth Largest GCD</h2>

<form method="post">
    <label for="numbers">Enter numbers (Max 6 values):</label><br>
    <input type="text" id="numbers" name="numbers" required><br><br>

    <label for="n">Enter position (which largest GCD you want to find):</label><br>
    <input type="number" id="n" name="n" min="1" max="6" value="2" required><br><br>

    <input type="submit" value="Submit">
</form>

<?php
if (isset($error)) {
    echo "<h3>$error</h3>";
} elseif (isset($result)) {
    echo "<h3>Result: The {$position}-th largest GCD is: " . $result . "</h3>";
}
?>

</body>
</html>
