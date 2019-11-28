<?php
namespace Anax\Curl;

/**
 * A model class retrievieng data from an external server.
 */
class CurlModel
{

    /**
     * Get curl from given url
     *
     * @return array
     */
    public function getCurl(string $url) : array
    {
        //  Initiate curl handler
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        // Execute
        $data = curl_exec($ch);
        // Closing
        curl_close($ch);

        return json_decode($data, true) ?? [];
    }


    /**
     * Get curl using multicurl
     *
     * @return array
     */
    public function getMultiCurl(array $urls) : array
    {
        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];
        // Add all curl handlers and remember them
        // Initiate the multi curl handler
        $mh = curl_multi_init();
        $chAll = [];
        foreach ($urls as $url) {
            $ch = curl_init("$url");
            curl_setopt_array($ch, $options);
            curl_multi_add_handle($mh, $ch);
            $chAll[] = $ch;
        }
        // Execute all queries simultaneously,
        // and continue when all are complete
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);
        // Close the handles
        foreach ($chAll as $ch) {
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);
        // All of our requests are done, we can now access the results
        $response = [];
        foreach ($chAll as $ch) {
            $data = curl_multi_getcontent($ch);
            $response[] = json_decode($data, true);
        }
        return $response;
    }
}
