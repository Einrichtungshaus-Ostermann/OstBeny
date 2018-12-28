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

namespace OstBeny\Listeners\Controllers\Frontend;

use Enlight_Event_EventArgs as EventArgs;
use Shopware_Controllers_Frontend_Detail as Controller;

class Detail
{
    /**
     * ...
     *
     * @var string
     */
    protected $viewDir;

    /**
     * ...
     *
     * @param string $viewDir
     */
    public function __construct($viewDir)
    {
        // set params
        $this->viewDir = $viewDir;
    }

    /**
     * ...
     *
     * @param EventArgs $arguments
     */
    public function onPreDispatch(EventArgs $arguments)
    {
        // get the controller
        /* @var $controller Controller */
        $controller = $arguments->get('subject');

        // get parameters
        $request = $controller->Request();
        $view = $controller->View();

        // only order action
        if (strtolower($request->getActionName()) !== 'index') {
            // nothing to do
            return;
        }

        // add template dir
        $view->addTemplateDir($this->viewDir);
    }

    /**
     * ...
     *
     * @param EventArgs $arguments
     */
    public function onPostDispatch(EventArgs $arguments)
    {
        // get the controller
        /* @var $controller Controller */
        $controller = $arguments->get('subject');

        // get parameters
        $request = $controller->Request();
        $view = $controller->View();

        // only order action
        if (strtolower($request->getActionName()) !== 'index') {
            // nothing to do
            return;
        }

        // get the article number
        $number = $view->getAssign('sArticle')['ordernumber'];

        // get every price
        $query = '
            SELECT article.*, marketplace.name
            FROM ost_beny_marketplaces AS marketplace
                LEFT JOIN ost_beny_articles AS article
                    ON marketplace.id = article.marketplaceId
                        AND article.number = :number
            WHERE 1 = 1
        ';
        $marketplaces = Shopware()->Db()->fetchAll($query, ['number' => $number]);

        // ...
        $view->assign('ostBeny', ['marketplaces' => $marketplaces]);
    }
}
