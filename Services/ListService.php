<?php declare(strict_types=1);

/**
 * Einrichtungshaus Ostermann GmbH & Co. KG - Beny
 *
 * @package   OstBeny
 *
 * @author    Eike Brandt-Warneke <e.brandt-warneke@ostermann.de>
 * @copyright 2018 Einrichtungshaus Ostermann GmbH & Co. KG
 * @license   proprietary
 */

namespace OstBeny\Services;

use GuzzleHttp\Client;

class ListService implements ListServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getList(string $marketplace)
    {
        // get the api key
        $apiKey = Shopware()->Container()->get('ost_beny.configuration')['apiKey'];

        // create the url
        $url = 'https://web.beny-ag.com/' .
            'api/beny/' .
            'login/' . $apiKey .
            '/export?marketplace=' . $marketplace;

        // create a new guzzle client
        $guzzle = new Client();

        // get the list
        $response = $guzzle->get($url, [
            'verify'          => false,
            'connect_timeout' => 15
        ]);

        // force the response as json
        $articles = $response->json();

        // and return it
        return $articles;
    }
}
