<?php

class FinalResult {
    // Cleanup our csv so we get just the details we want
    function getTransferDetails($csvRow) {
        unset($csvRow[1], $csvRow[3], $csvRow[4], $csvRow[5], $csvRow[9], $csvRow[12], $csvRow[13], $csvRow[14], $csvRow[15]);
        $transferDetails = array_values($csvRow);
        return $transferDetails;
    }

    function results($csv) {
        $csvFilePointer = fopen($csv, "r");
        list($currency, $failureCode, $failureMessage) = fgetcsv($csvFilePointer);
        $transferRecords = [];
        // Cycle through the csv file
        while(!feof($csvFilePointer)) {
            $csvRow = fgetcsv($csvFilePointer);
            if(count($csvRow) === 16) {
                list($bankCode, $branchCode, $accountNumber, $accountName, $subunits, $idFirst, $idLast) = $this->getTransferDetails($csvRow);

                $record = [
                    "amount" => [
                        "currency" => $currency,
                        "subunits" => !empty($subunits) ? (int) (floatval($subunits) * 100) : 0 // The float value of 100xsubunits before converting to int.
                    ],
                    "bank_account_name" => str_replace(" ", "_", strtolower($accountName)),
                    "bank_account_number" => !empty($accountNumber) ? (int) $accountNumber : "Bank account number missing",
                    "bank_branch_code" => !empty($branchCode) ? $branchCode : "Bank branch code missing",
                    "bank_code" => $bankCode,
                    "end_to_end_id" => !empty($idFirst) && !empty($idLast) ? $idFirst . $idLast : "End to end id missing"
                ];
                $transferRecords[] = $record;
            }
        }
        $transferRecords = array_filter($transferRecords);
        return [
            "filename" => basename($csv),
            "document" => $csvFilePointer,
            "failure_code" => $failureCode,
            "failure_message" => $failureMessage,
            "records" => $transferRecords
        ];
    }
}

?>
