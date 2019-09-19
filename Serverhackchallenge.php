<?php 

/* 

// found pass?
$flag = "9c04876fb689790317c6b17092edc50f1";
// end of pass?

// $flag by Unknown Sinister !!!
*/

$flag = "4b3de461fd3a5913cf8edb58470839a5";



$n = "35948145881546650497425055363061529726";
$x = bchexdec($flag); // $flag is 32 chars
echo bcpowmod(1511, $x, $n);
// output = 10899914993644372325321260353822561193
/*
*/

function bchexdec($dec) {
  $res = 0;
  $mn = 1;
  $l = strlen($dec);
  for($i=0;$i<$l;$i++) {
    $res = bcadd($res, bcmul($mn, hexdec($dec[$l-$i-1])));
    $mn = bcmul($mn, 16);
  }
  return $res;
}

?>

<?php
// algorithmic challenge 
// by djcoldcrown github djcoldcrown


$outBigNumber = "10899914993644372325321260353822561193";
// = 8333f4cf082aec2853b1951647693a9 

$nBigNumber = "35948145881546650497425055363061529726";
// = b0b5c6e6b0b5b7e6c6d0b1b0a8c3c7e 

$maxPossibleFlag ="";
//"ffffffffffffffffffffffffffffffff" ;  //max 32 hex number
for ($i=1;$i<=32;$i++){
    $maxPossibleFlag.="f";
    /*
    echo("Curr Hex(".$i."):".$maxPossibleFlag."\n");
    echo("TestHex2Dec:".bchexdec($maxPossibleFlag)."\n");
    */
}

$maxPossibleDec = bchexdec($maxPossibleFlag);

$xhex = ""; // = password

$ln1511 = log(1511);
$diffOk =  0.1;  //0

$startIteration = 1;
$bigStep = 5945; // just to show collisions

// dec2hex conversion test
// echo ($nBigNumber  . "=" . bcdechex($nBigNumber ));
echo (1234567890  . "=0x" . bcdechex(1234567890 ) . "h<br/>");
echo ("0x".bcdechex(1234567890)."h=".bchexdec( bcdechex(1234567890)));


$xx=bcadd(  bcmul($nBigNumber,$startIteration) ,  $outBigNumber);
$count=$startIteration;

echo("<hr/>". 
"<br/>Max Hex : ".$maxPossibleFlag.
"<br/>Max Dec : ".$maxPossibleDec.
"<br/>original n : ".$nBigNumber.
"<br/>original output : ".$outBigNumber.
"<br/>ln1511 : ".$ln1511.
"<hr/>");



while
    (true) {  //    debug

//    ($xx<=$maxPossibleDec) {  //    xx could not be more than maxPossibleDec
    
    //$pow1511X1=bcpow(1511,$xx,5);
    //$pow1511X2=bcpow(1511,$xx,6);
    $logXX=log($xx);
    $div=$logXX/$ln1511;
    $mod=fmod($logXX,$ln1511);
    $tK = testKey($xx,$nBigNumber);
    $hexXX = bcdechex($xx);
    
    echo (
          "<br/>T(" . $count . "):" .   //debug
          "<br/>X   =" . $xx.
          "<br/>TRes=" . $tK .
          "<br/>HexX=" . $hexXX .
          //"<br/>1511^X.1=" .$pow1511X1.
          //"<br/>1511^X.2=" .$pow1511X2.
          "<br/>logX=".$logXX.
          "<br/>div=".$div.
          "<br/>mod=".$mod.
          //"<br/>diffOk=".$diffOk.
          "<br/>");                    // debug
          
    if ($mod <= $diffOk) {
        echo ("<br/>Mod result less than allowed diff:<br/>".$mod."<".$diffOk."<br/>");
        if ($outBigNumber==$tK) {
            $xhex = bcdechex ($xx);  // password
            echo ("<br/>Pass in dec:" . $xx);    // = 3318129336095936218088426353755483295985
            echo ("<br/>Pass in hex:" . $xhex);  // = 9c04876fb689790317c6b17092edc50f1
            break;    
        } else {
            echo ("<br/>Collision passw: ".$hexXX."<br/>".
                  "Collision  test: ". testHexKey($hexXX, $nBigNumber).
                  "<hr/>");
            
        }
        
    }
    if ($count==5) {
        $count+=$bigStep;
        $xx=bcadd($xx, bcmul($nBigNumber,$bigStep));
    }
    $count += 1;
    $xx=bcadd($xx,$nBigNumber);
}

if ($xhex=="") {
    echo("<hr/>Next value is more than MaxPossible:<br/>".bcadd($xx,$nBigNumber));
    echo ("<br/>No password found.. ");
}



function testHexKey($f,$n){
    return bcpowmod(1511, bchexdec($f), $n);
}

function  testKey($test,$n) {
    return bcpowmod(1511,$test, $n);
}

function bcdechex($dec) {
    $hex="";
    while ($dec>1) {
        $mod = bcmod ($dec ,16);
        $hex = getHex($mod) . $hex ;
        $dec = bcdiv ($dec ,16);
    }
    return $hex;
}

function getHex ($d) {
    if (($d>=0) && ($d <10)) return $d;
    if ($d==10) return "a";
    if ($d==11) return "b";
    if ($d==12) return "c";
    if ($d==13) return "d";
    if ($d==14) return "e";
    if ($d==15) return "f";
    
}


?>

<!--
T(92):0### Test Result: 535958105533255449203969781594590227 Collision passw: 9c04876fb689790317c6b17092edc50f1
T(93):0### Test Result: 26150964946569123330752490725364183337 Collision passw: 9db53d369d3a2ebafe8d8222439688d6f
T(94):0### Test Result: 34235247559345442212051209649412665081 Collision passw: 9f65f2fd83eae472e55452d3f43f4c9ed
T(95):0### Test Result: 13562261469727746459919182327815895205 Collision passw: a116a8c46a9b9a2acc1b2385a4e81066b
T(96):0### Test Result: 18477566573039976195278693789610813173 Collision passw: a2c75e8b514c4fe2b2e1f4375590d42e9
T(97):0### Test Result: 12046942501056613702413064886009058117 Collision passw: a478145237fd059a99a8c4e9063997f67
T(98):0### Test Result: 20828165338462745170278111854887412241 Collision passw: a628ca191eadbb52806f959ab6e25bbe5
T(99):0### Test Result: 6665890032733178785794867996686365063 Collision passw: a7d97fe0055e710a6736664c678b1f863
T(100):0### Test Result: 11831552806930638753799353357080800505 Collision passw: a98a35a6ec0f26c24dfd36fe1833e34e1
T(101):0### Test Result: 4056749489274803104961878061713496359 Collision passw: ab3aeb6dd2bfdc7a34c407afc8dca715f
T(102):0### Test Result: 27184654875549717425550189901061122487 Collision passw: aceba134b97092321b8ad86179856addd
T(103):0### Test Result: 2590389514335985924786451337192299877 Collision passw: ae9c56fba02147ea0251a9132a2e2ea5b
T(104):0### Test Result: 26215243150191555556667522535008676807 Collision passw: b04d0cc286d1fda1e91879c4dad6f26d9
T(105):0### Test Result: 11823198455147993783016386941036099943 Collision passw: b1fdc2896d82b359cfdf4a768b7fb6357
T(106):0### Test Result: 10734573308255354934538590645925858807 Collision passw: b3ae785054336911b6a61b283c2879fd5
T(107):0### Test Result: 19717016593880947509756167338059422037 Collision passw: b55f2e173ae41ec99d6cebd9ecd13dc53
T(108):0### Test Result: 32928111948283578412689519484951018619 Collision passw: b70fe3de2194d4818433bc8b9d7a018d1
T(109):0### Test Result: 3215460372996877786084896938231238883 Collision passw: b8c099a508458a396afa8d3d4e22c554f
T(110):0### Test Result: 27463296623363932884818589333956778751 Collision passw: ba714f6beef63ff151c15deefecb891cd
T(111):0### Test Result: 25554054846128243962317604672922064633 Collision passw: bc220532d5a6f5a938882ea0af744ce4b
T(112):0### Test Result: 9682351134147538924772312063641042003 Collision passw: bdd2baf9bc57ab611f4eff52601d10ac9
T(113):0### Test Result: 6195028834749078935776248172023888167 Collision passw: bf8370c0a30861190615d00410c5d4747
T(114):0### Test Result: 20985989627124864772643123598430712181 Collision passw: c134268789b916d0ecdca0b5c16e983c5
T(115):0### Test Result: 27398956364093662767643604193224087529 Collision passw: c2e4dc4e7069cc88d3a3716772175c043
T(116):0### Test Result: 31098535493256897777944911215157949771 Collision passw: c4959215571a8240ba6a421922c01fcc1


T(5):
X =154692498519830974315021481806068680097
TRes=29870543294639433388287015493377796445
HexX=7460b1069cb01cbc36ef45bd8ea785a1
logX=87.93450261369
div=12.012045453404
mod=0.088179066417251

Mod result less than allowed diff:
0.088179066417251<0.1

Collision passw: 7460b1069cb01cbc36ef45bd8ea785a1
Collision test: 29870543294639433388287015493377796445

...

T(5953):
X =214010212347840854783496675836659109020071
TRes=16974979982570732028644647599924285149
HexX=274eb63a2f4239d4599d8ea5921ab8141a7
logX=95.166842361903
div=12.999998887014
mod=7.3205188146297

T(5954):
X =214046160493722401433994100892022170549797
TRes=35092843972377764991057368296848125175
HexX=275066eff628ea8a1184557643cb60d7e25
logX=95.167010321771
div=13.0000218307
mod=0.00015981222511474

Mod result less than allowed diff:
0.00015981222511474<0.1

Collision passw: 275066eff628ea8a1184557643cb60d7e25
Collision test: 35092843972377764991057368296848125175

T(5955):
X =214082108639603948084491525947385232079523
TRes=19697139410599705366492208325585490165
HexX=275217a5bd0f9b3fc96b1c46f57c099baa3
logX=95.167178253433
div=13.000044770532
mod=0.00032774388744716

Mod result less than allowed diff:
0.00032774388744716<0.1

Collision passw: 275217a5bd0f9b3fc96b1c46f57c099baa3
Collision test: 19697139410599705366492208325585490165


-->
