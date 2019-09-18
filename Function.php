<?php 
// PHP program to segregate even and 
// odd elements of array  
  
function segregateEvenOdd(&$arr, $size)  
{  
    // Initialize left and right indexes 
    $left = 0; 
    $right = $size-1;  
    while ($left < $right)  
    { 
        while ($arr[$left] % 2 == 0 && 
                    $left < $right)  
            $left++; 
        while ($arr[$right] % 2 == 1 &&  
                    $left < $right)  
            $right--;  
  
        if ($left < $right)  
        {  
            // Swap $arr[$left] and $arr[$right] 
            swap($arr[$left], $arr[$right]);  
            $left++;  
            $right--;  
        }  
    }  
}  
  
// UTILITY FUNCTIONS 
function swap(&$a, &$b)  
{  
    $temp = $a;  
    $a = $b;  
    $b = $temp;  
}  
  
// input array below
$arr = array(12, 34, 45, 9, 8, 90, 3);  
$arr_size = count($arr);  
  
segregateEvenOdd($arr, $arr_size);  
  
echo "Array after segregation ";  
for ($i = 0; $i < $arr_size; $i++)  
    echo $arr[$i]." ";
    ?>
