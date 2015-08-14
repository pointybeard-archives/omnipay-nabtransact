<?php

namespace Omnipay\NABTransact\Message;

use Omnipay\NABTransact\Message\AbstractResponse;

class PeriodicResponse extends AbstractResponse
{
	
    public static $STATUS_CODES = [
          0 => "Normal",
        300 => "Invalid Amount",
        301 => "Invalid Credit Card Number",
        302 => "Invalid Expiry Date",
        303 => "Invalid CRN",
        304 => "Invalid Merchant ID",
        305 => "Invalid BSB Number",
        306 => "Invalid Account Number",
        307 => "Invalid Account Name",
        309 => "Invalid CVV Number",
        313 => "General Database Error",
        314 => "Unable to Read Properties File",
        316 => "Invalid Action Type",
        318 => "Unable to Decrypt Account Details",
        327 => "Invalid Periodic Payment Type",
        328 => "Invalid Periodic Frequency",
        329 => "Invalid Number of Payments",
        332 => "Invalid Date Format",
        333 => "Triggered Payment Not Found",
        346 => "Duplicate CRN Found",
        347 => "Duplicate Allocated Variable Found",
        504 => "Invalid Merchant ID",
        505 => "Invalid URL",
        510 => "Unable To Connect To Server",
        511 => "Server Connection Aborted During Transaction",
        512 => "Transaction timed out By Client",
        513 => "General Database Error",
        514 => "Error loading properties file",
        515 => "Fatal Unknown Error",
        516 => "Request type unavailable",
        517 => "Message Format Error",
        518 => "Customer Not Registered",
        524 => "Response not received",
        545 => "System maintenance in progress",
        550 => "Invalid password",
        575 => "Not implemented",
        577 => "Too Many Records for Processing",
        580 => "Process method has not been called",
        595 => "Merchant Disabled",
    ];
	/*
    public static $RESPONSE_CODES = [
        '00' => "Approved",
        '01' => "Refer to Card Issuer ",
        '02' => "Refer to Issuer’s Special Conditions",
        '03' => "Invalid Merchant",
        '04' => "Pick Up Card",
        '05' => "Do Not Honour",
        '06' => "Error",
        '07' => "Pick Up Card, Special Conditions",
        '08' => "Approved",
        '09' => "Request in Progress",
        '10' => "Partial Amount Approved",
        '11' => "Approved (not used)",
        '12' => "Invalid Transaction",
        '13' => "Invalid Amount",
        '14' => "Invalid Card Number",
        '15' => "No Such Issuer",
        '16' => "Approved (not used)",
        '17' => "Customer Cancellation",
        '18' => "Customer Dispute",
        '19' => "Re-enter Transaction",
        '20' => "Invalid Response",
        '21' => "No Action Taken",
        '22' => "Suspected Malfunction",
        '23' => "Unacceptable Transaction Fee",
        '24' => "File Update not Supported by Receiver",
        '25' => "Unable to Locate Record on File",
        '26' => "Duplicate File Update Record",
        '27' => "File Update Field Edit Error",
        '28' => "File Update File Locked Out",
        '29' => "File Update not Successful",
        '30' => "Format Error",
        '31' => "Bank not Supported by Switch",
        '32' => "Completed Partially",
        '33' => "Expired Card—Pick Up",
        '34' => "Suspected Fraud—Pick Up",
        '35' => "Contact Acquirer—Pick Up",
        '36' => "Restricted Card—Pick Up",
        '37' => "Call Acquirer Security—Pick Up",
        '38' => "Allowable PIN Tries Exceeded",
        '39' => "No CREDIT Account",
        '40' => "Requested Function not Supported",
        '41' => "Lost Card—Pick Up",
        '42' => "No Universal Amount",
        '43' => "Stolen Card—Pick Up",
        '44' => "No Investment Account",
        '51' => "Insufficient Funds",
        '52' => "No Cheque Account",
        '53' => "No Savings Account",
        '54' => "Expired Card",
        '55' => "Incorrect PIN",
        '56' => "No Card Record",
        '57' => "Trans. not Permitted to Cardholder",
        '58' => "Transaction not Permitted to Terminal",
        '59' => "Suspected Fraud",
        '60' => "Card Acceptor Contact Acquirer",
        '61' => "Exceeds Withdrawal Amount Limits",
        '62' => "Restricted Card",
        '63' => "Security Violation",
        '64' => "Original Amount Incorrect",
        '65' => "Exceeds Withdrawal Frequency Limit",
        '66' => "Card Acceptor Call Acquirer Security",
        '67' => "Hard Capture—Pick Up Card at ATM",
        '68' => "Response Received Too Late",
        '75' => "Allowable PIN Tries Exceeded",
        '86' => "ATM Malfunction",
        '87' => "No Envelope Inserted",
        '88' => "Unable to Dispense",
        '89' => "Administration Error",
        '90' => "Cut-off in Progress",
        '91' => "Issuer or Switch is Inoperative",
        '92' => "Financial Institution not Found",
        '93' => "Trans Cannot be Completed",
        '94' => "Duplicate Transmission",
        '95' => "Reconcile Error",
        '96' => "System Malfunction",
        '97' => "Reconciliation Totals Reset",
        '98' => "MAC Error",
        '99' => "Reserved for National Use",
    ];
	*/

    public function isRedirect()
    {
        return false;
    }
	
    public function isSuccessful()
    {
        return ($this->getStatusCode() == 0 && $this->getCode() == '00');
    }

    public function getMessageId(){
        return $this->getMessageInfo()['messageID'];
    }

    public function getMessageInfo(){
        return (array)$this->data->MessageInfo;
    }

    public function getStatusCode(){
        return (int)$this->data->Status->statusCode;
    }

    public function getMessage()
    {
        return (string)$this->data->Periodic->PeriodicList->PeriodicItem->responseText;
    }

    public function getCode()
    {
        return (string)$this->data->Periodic->PeriodicList->PeriodicItem->responseCode;
    }

    public function getCustomerReference()
    {
        return (string)$this->data->Periodic->PeriodicList->PeriodicItem->crn;
    }
}
