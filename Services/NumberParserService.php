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

class NumberParserService implements NumberParserServiceInterface
{
    /**
     * @var array
     */
    private $length = [
        'company' => 2,
        'number'  => 8,
        'trail'   => 5
    ];

    /**
     * {@inheritdoc}
     */
    public function parseId($id)
    {
        // extract article number and remove zeros
        return ltrim(substr($id, 2, 8), '0');
    }

    /**
     * {@inheritdoc}
     */
    public function parseNumber($number, $company)
    {
        // use str_pad to lengthen the article number
        return str_pad($company, $this->length['company'], '0', STR_PAD_LEFT) .
            str_pad($number, $this->length['number'], '0', STR_PAD_LEFT) .
            str_repeat('0', $this->length['trail']);
    }
}
