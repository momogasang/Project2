<?php
require_once 'configPHP.php';
define('PATH_OF_IMG_FOLDER', str_replace("src\html&php", "images\\", $dir));
define("IMAGES_PER_PAGE", 16);

if (isset($_GET["pageIndex"]))
    $pageIndex = $_GET["pageIndex"];
else
    $pageIndex = 1;
if (isset($_GET['country']))
    $country = $_GET['country'];
else
    $country = '0';
if (isset($_GET['city']))
    $city = $_GET['city'];
else
    $city = '0';
if (isset($_GET['content']))
    $content = $_GET['content'];
else
    $content = '0';

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
$link->set_charset("UTF-8");
$link->select_db(DB_NAME);

if ($cityName == null && $countryName == null)
    $imageInfoArray = getImgList($link, '', '', '');
else
{
    if ($content == '')
        if ($cityName == '')
            $imageInfoArray = getImgList($link, '', getCountryCodeISO($link, $countryName), '');
        else
            if ($countryName == '')
                $imageInfoArray = getImgList($link, '', '', '');
            else
                $imageInfoArray = getImgList($link, '', '', getCityCode($link, $cityName, getCountryCodeISO($link, $countryName)));
    else
        if ($cityName == '')
            if ($countryName != '')
                $imageInfoArray = getImgList($link, $content, getCountryCodeISO($link, $countryName), '');
            else
                $imageInfoArray = getImgList($link, $content, '', '');
        else
            $imageInfoArray = getImgList($link, $content, '', getCityCode($link, $cityName, getCountryCodeISO($link, $countryName)));
}

function getCityCode($link, $cityName, $countryCodeISO)
{
    $query = "select GeoNameID from geocities where AsciiName = '" . $cityName . "' and CountryCodeISO = '" . $countryCodeISO . "';";
    $finalResult = mysqli_fetch_assoc(mysqli_query($link, $query));
    return $finalResult['GeoNameID'];
}

function getCountryCodeISO($link, $countryName)
{
    $query = "select ISO from geocountries where CountryName='" . $countryName . "';";
    $finalResult = mysqli_fetch_assoc(mysqli_query($link, $query));
    return $finalResult['ISO'];
}

function getImgList($link, $content, $countryCodeISO, $cityCode)
{
    if ($content != '')
        if ($cityCode != '')
            $query = "select ImageID,PATH from travelimage where CityCode=" . $cityCode . " and content='" . $content . "' order by Favor desc ;";
        else
            if ($countryCodeISO != '')
                $query = "select ImageID,PATH from travelimage where CountryCodeISO='" . $countryCodeISO . "' and content='" . $content . "' order by Favor desc ;";
            else
                $query = "select ImageID,PATH from travelimage where content='" . $content . "' order by Favor desc;";
    else
        if ($cityCode != '')
            $query = "select ImageID,PATH from travelimage where CityCode=" . $cityCode . " order by Favor desc ;";
        else
            if ($countryCodeISO != '')
                $query = "select ImageID,PATH from travelimage where CountryCodeISO='" . $countryCodeISO . "' order by Favor desc ;";
            else
                $query = "select ImageID,PATH from travelimage order by Favor desc ;";
    $result = mysqli_query($link, $query);
    $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $resultArray;
}


function printImage($singleImgInfoArray)
{
    $path = PATH_OF_IMG_FOLDER . $singleImgInfoArray['PATH'];
    $imageID = $singleImgInfoArray['ImageID'];
    print "
    <a href='detail.php?imageID=$imageID'>
        <img src='$path'>
    </a>
    ";
}

$start = ($pageIndex - 1) * IMAGES_PER_PAGE;
$end = $start + IMAGES_PER_PAGE;

$numberOfPages = count($imageInfoArray) / IMAGES_PER_PAGE;
if (count($imageInfoArray) % IMAGES_PER_PAGE > 0)
    $numberOfPages++;

?>
<html>
<body>
<div id="images">

    <?php
    for ($i = $start; $i < $end; $i++)
        printImage($imageInfoArray[$i]);
    ?>

</div>
</body>
</html>