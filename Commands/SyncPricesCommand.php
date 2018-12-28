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

namespace OstBeny\Commands;

use Shopware\Commands\ShopwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use OstBeny\Services\ListServiceInterface;
use OstBeny\Services\NumberParserServiceInterface;
use Enlight_Components_Db_Adapter_Pdo_Mysql as Db;

class SyncPricesCommand extends ShopwareCommand
{
    /**
     * ...
     *
     * @var Db
     */
    private $db;

    /**
     * ...
     *
     * @var ListServiceInterface
     */
    private $listService;

    /**
     * ...
     *
     * @var NumberParserServiceInterface
     */
    private $numberParserService;

    /**
     * @param Db                           $db
     * @param ListServiceInterface         $listService
     * @param NumberParserServiceInterface $numberParserService
     */
    public function __construct(Db $db, ListServiceInterface $listService, NumberParserServiceInterface $numberParserService)
    {
        parent::__construct();
        $this->db = $db;
        $this->listService = $listService;
        $this->numberParserService = $numberParserService;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // get every marketplace
        $query = '
            SELECT *
            FROM ost_beny_marketplaces
            ORDER BY id ASC
        ';
        $marketplaces = $this->db->fetchAll($query);

        // loop every marketplace
        foreach ($marketplaces as $marketplace) {
            // log
            $output->writeln('processing marketplace - name: ' . $marketplace['name'] . ' - key: ' . $marketplace['key']);
            $output->writeln('retrieving list');

            // get every article from beny
            $articles = $this->listService->getList($marketplace['key']);

            // log
            $output->writeln('processing articles');

            // start the progress bar
            $progressBar = new ProgressBar($output, count($articles));
            $progressBar->setRedrawFrequency(10);
            $progressBar->start();

            // loop every article
            foreach ($articles as $article) {
                // get the internal article number
                $number = $this->numberParserService->parseId($article['ID']);

                // we need a valid price
                if (((float) $article['NEW PRICE'] === 0) || ((float) $article['OLD PRICE'] === 0) || ((float) $article['BEST PRICE'] === 0)) {
                    // delete from beny
                    $query = '
                        DELETE FROM ost_beny_articles
                        WHERE number = ?
                            AND marketplaceId = ?
                    ';
                    $this->db->query($query, [
                        $number,
                        $marketplace['id']
                    ]);

                    // advance progress bar
                    $progressBar->advance();

                    // next
                    continue;
                }

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
                $this->db->query($query, [
                    date('Y-m-d H:i:s', $date->getTimestamp()),
                    $number,
                    $article['RANKING'],
                    (float) $article['BEST PRICE'] / 100,
                    $article['BEST OFFERER'],
                    $marketplace['id'],
                    date('Y-m-d H:i:s', $date->getTimestamp()),
                    $article['RANKING'],
                    (float) $article['BEST PRICE'] / 100,
                    $article['BEST OFFERER'],
                ]);

                // advance progress bar
                $progressBar->advance();
            }

            // done with this marketplace
            $progressBar->finish();
            $output->writeln('');
        }
    }
}
