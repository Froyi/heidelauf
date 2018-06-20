<?php declare(strict_types=1);

namespace Project\Module\Reader;

/**
 * Class TransponderService
 * @package     Project\Module\Reader
 */
class TransponderService
{
    protected const TRANSPONDER_FILE = 'transponder.txt';

    public function getTransponderCodes(): array
    {
        $transponderArray = [];
        $file = file(self::TRANSPONDER_FILE);
        $count = \count($file);

        for ($i = 0; $i < $count; $i++) {
            $fileData = explode('|', $file[$i]);

            $transponderArray[$fileData[0]] = $fileData[1];
        }

        return $transponderArray;
    }
}