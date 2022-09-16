<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApplicationStatu;
use App\User;
use App\Stock;
use App\StoreStoke;
use App\Sale;
use App\Product;
use App\Transaction;
use App\Patient;
use App\Customer;
use App\Price;
use App\LabService;
use App\ModeOfPayment;
use App\BudgetYear;
use App\CustomerBudget;
use App\Dependant;

const NAIRA_CODE = '₦';
const REFERENCE_RANDOM_NUMBER_LENGTH = 6;
const REFERENCE_FILE_NUMBER_LENGTH = 4;
const CASH_TRANSACTION_NUMBER_LENGTH = 4;


function generate_invoice_no()
{
	$dt = \Carbon\Carbon::now();
	$timestamp = $dt->hour . $dt->minute . $dt->second;
	$referenceNumber = randomDigits(REFERENCE_RANDOM_NUMBER_LENGTH);
	return $referenceNumber . $timestamp;
}

function randomDigits($numDigits)
{
	if ($numDigits <= 0) {
		return '';
	}
	return mt_rand(1, 9) . randomDigits($numDigits - 1);
}

// Naira Symbol &#8358;
function toMoney($val, $symbol = '₦', $r = 2)
{
	$n = $val;
	$c = is_float($n) ? 1 : number_format($n, $r);
	$d = '.';
	$t = ',';
	$sign = ($n < 0) ? '-' : '';
	$i = $n = number_format(abs($n), $r);
	$j = (($j = $i . length) > 3) ? $j % 3 : 0;

	return  $symbol . $sign . ($j ? substr($i, 0, $j) + $t : '') . preg_replace('/(\d{3})(?=\d)/', "$1" + $t, substr($i, $j));
}

// Number Format used by the System by Ghaji
function formatMoney($money)
{

	$formatted = "₦" . number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $money)), 2);
	return $money < 0 ? "({$formatted})" : "{$formatted}";
}

function convert_number_to_words($number)
{
	$hyphen      = '-';
	$conjunction = ' and ';
	$separator   = ', ';
	$negative    = 'negative ';
	$decimal     = ' point ';
	$dictionary  = array(
		0                   => 'zero',
		1                   => 'one',
		2                   => 'two',
		3                   => 'three',
		4                   => 'four',
		5                   => 'five',
		6                   => 'six',
		7                   => 'seven',
		8                   => 'eight',
		9                   => 'nine',
		10                  => 'ten',
		11                  => 'eleven',
		12                  => 'twelve',
		13                  => 'thirteen',
		14                  => 'fourteen',
		15                  => 'fifteen',
		16                  => 'sixteen',
		17                  => 'seventeen',
		18                  => 'eighteen',
		19                  => 'nineteen',
		20                  => 'twenty',
		30                  => 'thirty',
		40                  => 'fourty',
		50                  => 'fifty',
		60                  => 'sixty',
		70                  => 'seventy',
		80                  => 'eighty',
		90                  => 'ninety',
		100                 => 'hundred',
		1000                => 'thousand',
		1000000             => 'million',
		1000000000          => 'billion',
		1000000000000       => 'trillion',
		1000000000000000    => 'quadrillion',
		1000000000000000000 => 'quintillion'
	);

	if (!is_numeric($number)) {
		return false;
	}

	if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
		// overflow
		trigger_error(
			'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
			E_USER_WARNING
		);
		return false;
	}

	if ($number < 0) {
		return $negative . convert_number_to_words(abs($number));
	}

	$string = $fraction = null;

	if (strpos($number, '.') !== false) {
		list($number, $fraction) = explode('.', $number);
	}

	switch (true) {
		case $number < 21:
			$string = $dictionary[$number];
			break;
		case $number < 100:
			$tens   = ((int) ($number / 10)) * 10;
			$units  = $number % 10;
			$string = $dictionary[$tens];
			if ($units) {
				$string .= $hyphen . $dictionary[$units];
			}
			break;
		case $number < 1000:
			$hundreds  = $number / 100;
			$remainder = $number % 100;
			$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
			if ($remainder) {
				$string .= $conjunction . convert_number_to_words($remainder);
			}
			break;
		default:
			$baseUnit = pow(1000, floor(log($number, 1000)));
			$numBaseUnits = (int) ($number / $baseUnit);
			$remainder = $number % $baseUnit;
			$string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
			if ($remainder) {
				$string .= $remainder < 100 ? $conjunction : $separator;
				$string .= convert_number_to_words($remainder);
			}
			break;
	}

	if (null !== $fraction && is_numeric($fraction)) {
		$string .= $decimal;
		$words = array();
		foreach (str_split((string) $fraction) as $number) {
			$words[] = $dictionary[$number];
		}
		$string .= implode(' ', $words);
	}

	return ucwords($string);
}


function generateTransactionId()
{
	$dt = \Carbon\Carbon::now();
	// $year = $dt->year;
	$timestamp = $dt->minute . $dt->second . $dt->year;
	$transactionNumber = randomDigits(REFERENCE_RANDOM_NUMBER_LENGTH);
	return  $transactionNumber . $timestamp;
}

function appsettings()
{
	$app = ApplicationStatu::find(1);

	// dd($app);
	return  $app;
}

function typeOfPaymentOnReceipt($modeOfPaymentId)
{

	$modePayment = ModeOfPayment::where('id', '=', $modeOfPaymentId)->first();

	// dd($modePayment);

	switch ($modePayment->id) {
		case 1:
			# code...
			$modeTypeName = "<b style='color:Green'>Cash</b>";
			break;

		case 2:
			# code...
			$modeTypeName = "<b style='color:Green'>Bank Teller</b>";
			break;

		case 3:
			# code...
			$modeTypeName = "<b style='color:Green'>Internet Banking</b>";
			break;

		case 4:
			# code...
			$modeTypeName = "<b style='color:Green'>Point of Sales</b>";
			break;

		case 5:
			# code...
			$modeTypeName = "<b style='color:Blue'>Credit Account</b>";
			break;

		default:
			# code...
			$modeTypeName = "<b style='color:Green'>Mode of Payment not Selected</b>";
			break;
	}

	return $modeTypeName;
}

function getInvoiceStatus($paymentId)
{

	$paymentMode = ModeOfPayment::where('id', '=', $paymentId)->first();

	if ($paymentMode->mode_of_payment_id == 5) {
		$status = '<b style="color:Red">Credit Account</b>';
	} else {
		$status = '<b style="color:Green">Paid</b>';
	}

	return $status;
}

function userfullname($id)
{

	$user = User::find($id);
	$othername = ($user->othername) ? $user->othername : ' ';
	$fullname = $user->surname . ' ' . $user->firstname . ' ' . $othername;

	return  ucwords($fullname);
}

function dependantfullname($id)
{

	$dependant = Dependant::find($id);
	return  ucwords($dependant->fullname);
}

function dateSplit($date)
{
	$getDate = explode(' ', $date);
	$mainDate = $getDate[0];
	$mainTime = $getDate[1];

	return $mainDate;
}

function reOrderAlertFlag($productId, $reOrderAlert)
{
	$storeStocks = StoreStoke::where('product_id', '=', $productId)->get();
	$val = "";

	foreach ($storeStocks as $storeStock) {

		$getStockCurrentQ = $storeStock->current_quantity;

		if ($getStockCurrentQ > $reOrderAlert) {
			$val = '<span class="badge badge-success"> In Stock </span>';
		} elseif ($getStockCurrentQ == $reOrderAlert) {
			$val .= '<span class="badge badge-warning"> Low in Stock </span>';
		} elseif ($getStockCurrentQ == 0) {
			$val .= '<span class="badge badge-danger"> Out of Stock </span>';
		} elseif ($getStockCurrentQ < $reOrderAlert) {
			$val .= '<span class="badge badge-dark"> Very Low </span>';
		} else {
			$val .= '<span class="badge badge-info"> Review Product </span>';
		}
	}

	return $val;
}

function generateFileNo()
{
    // $dt = \Carbon\Carbon::now();
    // // $year = $dt->year;
    // $timestamp =  $dt->year . $dt->month;
    // $fileNumber = randomDigits(REFERENCE_FILE_NUMBER_LENGTH);
    // return  $fileNumber . $timestamp;
    $p = \App\Patient::orderBy('file_no','DESC')->first()->file_no;
    return $p + 1;
}


function generateCashPaymentTransaction()
{
	$dt = \Carbon\Carbon::now();
	// $year = $dt->year;
	$tstamp = $dt->year . $dt->minute . $dt->second;
	$transNumber = randomDigits(CASH_TRANSACTION_NUMBER_LENGTH);
	return  $transNumber . $tstamp;
}

function getBudgetYear()
{
	$getBudget = BudgetYear::where('closed', '=', 0)->where('visible', '=', 1)->first();
	$getyear = $getBudget->id;
	return $getyear;
}

function getBudgetYearName($id)
{
	$getBudget = BudgetYear::find($id);
	$getyear = $getBudget->year_name;
	return $getyear;
}

function getLabId($id)
{
	$getLab = LabService::find($id);
	$getLab_id = $getLab->lab_id;
	return $getLab_id;
}

function showFileNumber($id)
{
	$pfile = Patient::where('user_id', '=', $id)->first();
	$getItem = $pfile->file_no;
      return $getItem ;
}
