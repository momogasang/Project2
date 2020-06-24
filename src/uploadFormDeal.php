<?php  //后端文件，处理文件上传的表单
$dir = dirname(__FILE__);
define('PATH_OF_IMG_FOLDER',str_replace("src\html&php","images\\",$dir));

function getNoneRepeatFileName($link, $initialFileName) //获取非重复的数字作为文件名，以防不同用户上传同名文件
{
    $query = "select PATH from travelimage";
    $result = mysqli_query($link, $query);
    $array = array_column(mysqli_fetch_all($result), 0);
    $numberArray = array();
    for ($i = 0; $i < count($array); $i++)
    {
        $dotPosition = stripos($array[$i], ".");
        $numSubString = substr($array[$i], 0, $dotPosition);
        array_push($numberArray, (int)$numSubString);
    }
    $dotPosition = stripos($initialFileName, ".");
    $suffix = substr($initialFileName, $dotPosition);
    do
    {
        $finalNum = rand(1000000000, 10000000000);
    } while (in_array($finalNum, $numberArray));
    return $finalNum . $suffix;
}

$uid = $_COOKIE['UID'];
$content = $_POST['content'];
$countryName = $_POST['country'];
$cityName = $_POST['city'];
$title = $_POST['title'];
$description = $_POST['description'];
$imageFile=$_POST['file'];

if (true)//验证登陆信息
{
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
    mysqli_select_db($link, DB_NAME);
    mysqli_set_charset($link, "utf8");

    $query = "select ISO from geocountries where lower(CountryName)=lower('" . $countryName . "');";
    try
    {
        $countryISO = mysqli_fetch_row(mysqli_query($link, $query))[0];
    } catch (Exception $exception)
    {
        echo "<script>window.location.href='upload.php';alert('please enter right country name!')</script>";
    }


    $query = "select GeoNameID from geocities where CountryCodeISO='" . $countryISO . "' and lower(AsciiName)=lower('" . $cityName . "');";
    try
    {
        $cityID = mysqli_fetch_row(mysqli_query($link, $query))[0];
    } catch (Exception $exception)
    {
        echo "<script>window.location.href='upload.php';alert('please enter right city name!')</script>";
    }

    $initialFileName = $imageFile["name"];
    $fileName = getNoneRepeatFileName($link, $initialFileName);
    $dir = dirname(__FILE__);
    $destination = PATH_OF_IMG_FOLDER . $fileName;

    $query = "insert into travelimage (Title, Description, CityCode, CountryCodeISO, UID, PATH,content) values ('$title','$description',$cityID,'$countryISO',$uid,'$fileName','$content');";
    //echo $query;
    mysqli_query($link, $query);

    mysqli_close($link);

    echo "<script>window.location.href='myPhotos.php'</script>";
}
else
{
    //重新跳转回登陆界面的代码
}
