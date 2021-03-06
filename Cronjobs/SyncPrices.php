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

use OstBeny\Services\ListServiceInterface;
use OstBeny\Services\NumberParserServiceInterface;
use Shopware_Components_Cron_CronJob as CronJob;

class SyncPrices
{
    /**
     * ...
     *
     * @param CronJob $cronjob
     *
     * @return bool
     */
    public function run(CronJob $cronjob)
    {
        /* @var $listService ListServiceInterface */
        $listService = Shopware()->Container()->get('ost_beny.list_service');

        /* @var $numberParserService NumberParserServiceInterface */
        $numberParserService = Shopware()->Container()->get('ost_beny.number_parser_service');

        // get every marketplace
        $query = '
            SELECT *
            FROM ost_beny_marketplaces
            ORDER BY id ASC
        ';
        $marketplaces = Shopware()->Db()->fetchAll($query);

        // loop every marketplace
        foreach ($marketplaces as $marketplace) {
            // get every article from beny
            $articles = $listService->getList($marketplace['key']);

            // log
            $this->log('processing marketplace - name: ' . $marketplace['name'] . ' - key: ' . $marketplace['key'] . ' - articles: ' . count($articles));

            // loop every article
            foreach ($articles as $article) {
                // get the internal article number
                $number = $numberParserService->parseId($article['ID']);

                // log
                $this->log('processing - article: ' . $article['ID'] . ' - number: ' . $number . ' - ', false);

                // we need a valid price
                if (((float) $article['NEW PRICE'] === 0) || ((float) $article['OLD PRICE'] === 0) || ((float) $article['BEST PRICE'] === 0)) {
                    // log
                    $this->log('removing article');

                    // delete from beny
                    $query = '
                        DELETE FROM ost_beny_articles
                        WHERE number = ?
                            AND marketplaceId = ?
                    ';
                    Shopware()->Db()->query($query, [
                        $numberParserService->parseId($article['ID']),
                        $marketplace['id']
                    ]);

                    // next
                    continue;
                }

                // log
                $this->log('updating article');

                // create date to work with
                $date = new \DateTime($article['LAST UPDATE']);

                // update or insert article
                $query = '
                    INSERT INTO `ost_beny_articles` (`id`, `date`, `number`, `ranking`, `price`, `competitor`, `marketplaceId`)
                    VALUES (NULL, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                        `date` = ?,
                        `ranking` = ?,
                        `price` = ?,
                        `competitor` = ?;
                ';
                Shopware()->Db()->query($query, [
                    date('Y-m-d H:i:s', $date->getTimestamp()),
                    $numberParserService->parseId($article['ID']),
                    $article['RANKING'],
                    (float) $article['BEST PRICE'] / 100,
                    $article['BEST OFFERER'],
                    $marketplace['id'],
                    date('Y-m-d H:i:s', $date->getTimestamp()),
                    $article['RANKING'],
                    (float) $article['BEST PRICE'] / 100,
                    $article['BEST OFFERER'],
                ]);
            }
        }

        // done
        return true;
    }

    /**
     * ...
     *
     * @param string $message
     * @param mixed  $nl
     */
    private function log($message = '', $nl = true)
    {
        // ...
        echo $message . (($nl === true) ? '<br />' : '');
    }
}
