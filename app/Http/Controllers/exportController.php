<?php

namespace App\Http\Controllers;
use League\Csv\Writer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class exportController extends Controller
{
    //
    public function exportLeads()
    {
        // Make the API call
        $response = Http::get('https://mapi.indiamart.com/wservce/crm/crmListing/v2/?glusr_crm_key=mRyyEr1s43zBTfes4HeO7liPpFXGnTdr&start_time=20-Feb-2024&end_time=26-Feb-2024');
    
        // Parse the JSON response
        $data = $response->json();
    
        // Define the headers for the CSV file
        $headers = [
            'Unique Query ID',
            'Query Type',
            'SENDER_NAME',
            'SENDER_MOBILE',
            'SENDER_EMAIL',
            'SENDER_CITY',
            'SUBJECT',
            'QUERY_PRODUCT_NAME',
            'QUERY_MESSAGE',
            // Add other headers as needed
        ];
    
        // Prepare the data for CSV
        $rows = [];
        foreach ($data['RESPONSE'] as $lead) {
            $rows[] = [
                $lead['UNIQUE_QUERY_ID'],
                $lead['QUERY_TYPE'],
                $lead['SENDER_NAME'],
                $lead['SENDER_MOBILE'],
                $lead['SENDER_EMAIL'],
                $lead['SENDER_CITY'],
                $lead['SUBJECT'],
                $lead['QUERY_PRODUCT_NAME'],
                $lead['QUERY_MESSAGE'],
                // Add other fields as needed
            ];
        }
    
        // Create a new CSV writer instance
        $writer = Writer::createFromFileObject(new \SplTempFileObject());
    
        // Insert the header
        $writer->insertOne($headers);
    
        // Insert the data
        $writer->insertAll($rows);
    
        // Return the CSV file
        return response($writer->getContent(), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="leads.csv"',
        ]);
    }



    public function fetchAndStoreLeadsForPastYear()
    {
    // $today = '2023-03-16'; // Get today's date

    // while (strtotime($today) <= strtotime(date('Y-m-d'))) { // Loop until today's date
    //     $endDate = date('Y-m-d', strtotime($today . ' + 6 days'));
        
    //     try {
    //         // Construct API endpoint URL with the calculated dates
    //         $apiUrl = 'https://mapi.indiamart.com/wservce/crm/crmListing/v2/?glusr_crm_key=' . env('LEAD_API_KEY') . '&start_time=' . $today . '&end_time=' . $endDate;

    //         // Make the API call with a 5-minute delay (adjusted to 30 seconds for demonstration)
    //         sleep(30); // Delay for demonstration purposes (replace with 300 for actual 5-minute wait)
    //         $response = Http::get($apiUrl);

    //         $this->processAndStoreLeads($response);
    //     } catch (\Exception $e) {
    //         // Handle API errors gracefully (log, retry, etc.)
    //         echo "Error fetching data: " . $e->getMessage() . PHP_EOL;
    //     }

    //     // Move to the next week
    //     $today = date('Y-m-d', strtotime($today . ' + 7 days'));
    // }
    $apiUrl = 'https://mapi.indiamart.com/wservce/crm/crmListing/v2/?glusr_crm_key=mRyyEr1s43zBTfes4HeO7liPpFXGnTdr&start_time=10-Mar-2024&end_time=15-Mar-2024';
    $response = Http::get($apiUrl);


            $this->processAndStoreLeads($response);
    }

    /**
     * Processes the API response, extracts data, and stores it in the database table.
     *
     * @param \Illuminate\Http\Client\Response $response
     * @return void
     */
    private function processAndStoreLeads($response)
    {
        // dd($response);
        
        Log::info($response);

        try{
                if ($response->successful()) {
                    $data = $response->json();
        
                    // Extract relevant data (assuming `leads` table exists)
                    $leads = [];
                    foreach ($data['RESPONSE'] as $lead) {
                        $leads[] = [
                        'unique_query_id' => $lead['UNIQUE_QUERY_ID'],
                        'query_type' => $lead['QUERY_TYPE'],
                        'sender_name' => $lead['SENDER_NAME'],
                        'sender_mobile' => $lead['SENDER_MOBILE'],
                        'sender_email' => $lead['SENDER_EMAIL'],
                        'sender_company' => $lead['SENDER_COMPANY'] ?? null, // Handle potentially missing fields
                        'sender_address' => $lead['SENDER_ADDRESS'] ?? null,
                        'sender_city' => $lead['SENDER_CITY'],
                        'sender_state' => $lead['SENDER_STATE'] ?? null,
                        'sender_pincode' => $lead['SENDER_PINCODE'] ?? null,
                        'sender_country_iso' => $lead['SENDER_COUNTRY_ISO'] ?? null,
                        'sender_mobile_alt' => $lead['SENDER_MOBILE_ALT'] ?? null,
                        'sender_phone' => $lead['SENDER_PHONE'] ?? null,
                        'sender_phone_alt' => $lead['SENDER_PHONE_ALT'] ?? null,
                        'sender_email_alt' => $lead['SENDER_EMAIL_ALT'] ?? null,
                        'query_product_name' => $lead['QUERY_PRODUCT_NAME'],
                        'query_message' => $lead['QUERY_MESSAGE'],
                        // Exclude 'subject' as it's not present in the migration
                        'receiver_mobile' => $lead['RECEIVER_MOBILE'] ?? null,
                            // Add other fields as needed
                        ];
                    }
        
                    // Insert data into the database using a transaction for consistency
                    DB::transaction(function () use ($leads) {
                        DB::table('leads')->insert($leads);
                    });
                    Log::info('Lead data fetching and storage completed.');
                } else {
                    echo "API request failed with status code: " . $response->getStatusCode() . PHP_EOL;
                }

            }catch (\Exception $e) {
                Log::error('Error fetching data: ' . $e->getMessage());
                // ... handle other error scenarios
            }

        
    }


}
