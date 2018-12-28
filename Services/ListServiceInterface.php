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

interface ListServiceInterface
{
    /**
     * Get the beny article list for the given marketplace.
     *
     * @param string $marketplace
     *
     * @return array
     */
    public function getList(string $marketplace);
}
