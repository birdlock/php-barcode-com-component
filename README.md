# PHP Barcode COM Component


This is the [COM component][1] for making PHP barcode reader.

## Getting Started
1. Create a new project named test. Under the project root directory, create two php files - test.php and readbarcode.php. Then copy dynamsoftbarcodereader.php from the SDK package to the project folder. 

2. Edit test.php as follows: 

    ```
    <html>
    <head/>
    <body>
        <h1>Dynamsoft Barcode Reader PHP Simple Sample</h1>
        <form action="readbarcode.php" method="post" enctype="multipart/form-data">
            Select barcode image:
            <input type="file" name="barcodefile" id="barcodefile" accept="image/*" /><br/>
            <input type="submit" value="Read Barcode" name="submit"/>
        </form>
    </body>
    </html>
    ```
    Edit readbarcode.php as follows: 

    ``` 
    <?php
    include "dynamsoftbarcodereader.php";

    $uploadfile = $_FILES["barcodefile"]["tmp_name"];

    $br = new BarcodeReader();
    $br->initLicense("<your license key here>");
    $br->decodeFile($uploadfile);

    $cnt = $br->getBarcodesCount();
    echo "Barcode Count: $cnt <br />";
    for ($i = 0; $i < $cnt; $i++) {
        $res = $br->getBarcodeResult($i);
        echo "$i. $res->BarcodeFormatString , $res->BarcodeText<br />";
    }
    ?>
    ```
    
    Please replace < your license key here > with valid values. The licenses can be found in the **[INSTALL FOLDER]\LicenseManager.exe**.

3. Suppose you deploy the sample to WampServer, please copy test folder to [WampServer ROOT PATH]\www folder. Start your WampServer and visit **http://[ip]:[port]/test/test.php** to verify if it works.

    **Note: **
    If you recieve the "Class 'COM' not found" error, please check whether the COM extension is enable in php.ini: 
    
    ```
    extension=php_com_dotnet.dll
    ``` 

[1]:http://www.dynamsoft.com/Products/barcode-scanner-php.aspx
    
