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

namespace OstBeny\Cronjobs;

use Shopware_Components_Cron_CronJob as CronJob;
use GuzzleHttp\Client;
use OstBeny\Services\NumberParserServiceInterface;

class SyncPrices
{



    /**
     * ...
     *
     * @param CronJob   $cronjob
     *
     * @return boolean
     */

    public function run( CronJob $cronjob )
    {
        $apiKey = Shopware()->Container()->get( "ost_beny.configuration" )['apiKey'];
        $url = "https://web.beny-ag.com/";

        $path = "api/beny/";



        $query = "
            SELECT *
            FROM ost_beny_marketplaces
            ORDER BY id ASC
        ";
        $marketplaces = Shopware()->Db()->fetchAll( $query );




        /* @var $numberParserService NumberParserServiceInterface */
        $numberParserService = Shopware()->Container()->get( "ost_beny.number_parser_service" );


        foreach ( $marketplaces as $marketplace )
        {
            $guzzle = new Client();


            $all = $url . $path . "login/" . $apiKey . "/export?marketplace=" . $marketplace['key'];




            $response = $guzzle->get( $all, array(
                'verify' => false,
                'connect_timeout' => 15
            ));


            $json = $response->json();


            foreach ( $json as $article )
            {
                // we need price
                if ( ( (float) $article['NEW PRICE'] == 0 ) or ( (float) $article['OLD PRICE'] == 0 ) or ( (float) $article['BEST PRICE'] == 0 ) )
                {
                    $query = "
                        DELETE FROM ost_beny_articles
                        WHERE number = ?
                            AND marketplaceId = ?
                    ";
                    Shopware()->Db()->query( $query, array(
                        $numberParserService->parseId( $article['ID'] ),
                        $marketplace['id']
                    ));

                    continue;
                }





                $date = new \DateTime( $article['LAST UPDATE'] );



                $query = "
                    INSERT INTO `ost_beny_articles` (`id`, `date`, `number`, `ranking`, `price`, `competitor`, `marketplaceId`)
                    VALUES (NULL, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                        `date` = ?,
                        `ranking` = ?,
                        `price` = ?,
                        `competitor` = ?;
                ";
                Shopware()->Db()->query( $query, array(
                    date( "Y-m-d H:i:s", $date->getTimestamp() ),
                    $numberParserService->parseId( $article['ID'] ),
                    $article['RANKING'],
                    (float) $article['BEST PRICE'] / 100,
                    $article['BEST OFFERER'],
                    $marketplace['id'],
                    date( "Y-m-d H:i:s", $date->getTimestamp() ),
                    $article['RANKING'],
                    (float) $article['BEST PRICE'] / 100,
                    $article['BEST OFFERER'],
                ));

            }

        }








        return true;

    }



    /**
     * ...
     *
     * @param string   $message
     *
     * @return void
     */

    private function log( $message = "" )
    {
        // ...
        echo $message . "<br />";
    }






}
