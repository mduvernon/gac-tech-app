<?php

namespace Domain\Gac\Helper;

class TicketArchiveHelper implements TicketArchiveHelperInterface
{
    static $ARCHIVE_PATH = __DIR__ . '/../Resources/Ftp/CSV/tickets_appels_201202.csv';


    public function findAll(?array $filter)
    {

    }

    public function applyFilter(array $filter)
    {
        if (isset($filter['type'])) {
            // @todo - contain
        }
        if (isset($filter[''])) {
        }
        if (isset($filter[''])) {
        }
        if (isset($filter[''])) {
        }
    }

    /**
     * @return array
     */
    public function readArchive(): array
    {
        // open csv file
        if (!($fp = fopen(self::$ARCHIVE_PATH, 'r'))) {
            die("Can't open file...");
        }

        $row = 0;
        while (($data = fgetcsv($fp, null, ";")) !== FALSE) {
            $row++;
            if ($row == 2) {
                //read csv headers
                $header = fgetcsv($fp, null, ";");
                $header = array_map('trim', $header);
                $header = [
                    'account', 'bill', 'subscriber', 'date',
                    'hour', 'real_duration', 'volume_duration',
                    'type'
                ];
            }
            if ($row > 2) {
                $json[] = array_combine($header, $data);
            }
        }
        // release file handle
        fclose($fp);

        // encode array to json
        return $json;
    }
}