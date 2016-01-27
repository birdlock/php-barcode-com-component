<?php
 /*
 *	DynamsoftBarcodeReader.php
 *	Dynamsoft Barcode Reader PHP API file.
 *
 *	Copyright (C) 2016 Dynamsoft Corporation.
 *	All Rights Reserved.
 */
 
class BarcodeFormat
{
	const OneD = 0x3FF;
	
	const CODE_39 = 0x1;
	const CODE_128 = 0x2;
	const CODE_93 = 0x4;
	const CODABAR = 0x8;
	const ITF = 0x10; 
	const EAN_13 = 0x20;
	const EAN_8 = 0x40;
	const UPC_A = 0x80;
	const UPC_E = 0x100;
	const INDUSTRIAL_25 = 0x200;
	
	const PDF417 = 0x2000000;
	const QR_CODE = 0x4000000;
	const DATAMATRIX = 0x8000000;
}


class BarcodeResult
{
	public $BarcodeText;
	public $BarcodeData;
	public $BarcodeFormat;
	public $BarcodeFormatString;
	public $Left;
	public $Top;
	public $Width;
	public $Height;
	public $X1;
	public $Y1;
	public $X2;
	public $Y2;
	public $X3;
	public $Y3;
	public $X4;
	public $Y4;
	public $PageNum;
	
	function __construct($barcode)
	{
		if($barcode == NULL)
			throw new Exception("BarcodeResult:NULL Pointer");
			
		$this->BarcodeText = $barcode->BarcodeText;
		$this->Left = $barcode->Left;
		$this->Top = $barcode->Top;
		$this->Width = $barcode->Width;
		$this->Height = $barcode->Height;
		$this->X1 = $barcode->X1;
		$this->Y1 = $barcode->Y1;
		$this->X2 = $barcode->X2;
		$this->Y2 = $barcode->Y2;
		$this->X3 = $barcode->X3;
		$this->Y3 = $barcode->Y3;
		$this->X4 = $barcode->X4;
		$this->Y4 = $barcode->Y4;
		$this->PageNum = $barcode->PageNum;
		
			
		$format = $barcode->BarcodeFormat;
		$this->BarcodeFormat = (int)($format->Type);
		$this->BarcodeFormatString = $format->TypeString;
			
		$result = $barcode->BarcodeData;
		$count = count($result);
		$this->BarcodeData = array();
		for($i = 0 ;$i < $count; $i++)
		{
			array_push($this->BarcodeData,(int)$result[$i]);
		}	
	}
}


class BarcodeReader
{
	private $m_reader;
	private $m_option;
	private $m_resultArray;
	
	
	function __construct()
	{
		$this->m_reader = new COM("DBRCtrl.BarcodeReader") or die("cannot build BarcodeReader com");
		$this->m_option = new COM("DBRCtrl.ReaderOptions") or die("cannot build BarcodeReader com");
	}
	
	function initLicense($key)
	{
		if($this->m_reader == NULL)
			throw new Exception("BarcodeReader:NULL Pointer");
		$this->m_reader->InitLicense($key);
	}
	
	function decodeFile($filename)
	{
		if($this->m_reader == NULL)
			throw new Exception("BarcodeReader:NULL Pointer");
		$this->m_reader->DecodeFile($filename);
		$this->m_resultArray = $this->m_reader->Barcodes;
	}
	
	function decodeFileRect($filename,$left,$top,$width,$height)
	{
		if($this->m_reader == NULL)
			throw new Exception("BarcodeReader:NULL Pointer");
		$this->m_reader->DecodeFileRect($filename,$left,$top,$width,$height);
		$this->m_resultArray = $this->m_reader->Barcodes;
	}	
	
	function decodeBase64String($FileStream)
	{
		if($this->m_reader == NULL)
			throw new Exception("BarcodeReader:NULL Pointer");
			
		$this->m_reader->DecodeBase64String($FileStream);
		$this->m_resultArray = $this->m_reader->Barcodes;
	}
	
	function decodeBase64StringRect($FileStream,$left,$top,$width,$height)
	{
		if($this->m_reader == NULL)
			throw new Exception("BarcodeReader:NULL Pointer");
		$this->m_reader->DecodeBase64StringRect($FileStream,$left,$top,$width,$height);
		$this->m_resultArray = $this->m_reader->Barcodes;
	}
	
	function getBarcodesCount()
	{
		if($this->m_reader == NULL)
			throw new Exception("BarcodeReader:NULL Pointer");
		return $this->m_reader->BarcodesCount;
	}
	
	function setBarcodeFormats($format)
	{
		if($this->m_reader == NULL)
			throw new Exception("BarcodeReader:NULL Pointer");		
		$this->m_option->BarcodeFormats = $format;
		//$this->m_option->MaxBarcodesNumPerPage = $num;
		$this->m_reader->ReaderOptions =$this->m_option;
	}
	
	function setMaxBarcodesNumPerPage($num)
	{
		if($this->m_reader == NULL)
			throw new Exception("BarcodeReader:NULL Pointer");	
		$this->m_option->MaxBarcodesNumPerPage = $num;
		$this->m_reader->ReaderOptions =$this->m_option;
	}
	
	function getBarcodeResult($index)
	{
		//echo  $this->m_resultArray;
		if($this->m_resultArray == NULL)
			throw new Exception("BarcodeReader:NULL Pointer");
		if($index > ($this->getBarcodesCount()-1))
			throw new Exception("Error:Index is larger than count");
		return new BarcodeResult($this->m_resultArray->Item($index));
	}
	
	function getErrorCode()
	{
		if($this->m_reader == NULL)
			throw new Exception("BarcodeReader:NULL Pointer");	
		return $this->m_reader->ErrorCode;
	}
	
	function getErrorString()
	{
		if($this->m_reader == NULL)
			throw new Exception("BarcodeReader:NULL Pointer");	
		return $this->m_reader->ErrorString;
	}
}

?>