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

interface NumberParserServiceInterface
{
    /**
     * Extract the article number from an id.
     *
     * @param string $id
     *
     * @return string
     */
    public function parseId($id);

    /**
     * Create an id from article number and company.
     *
     * @param string $number
     * @param int    $company
     *
     * @return string
     */
    public function parseNumber($number, $company);
}
