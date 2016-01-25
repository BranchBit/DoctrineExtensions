<?php
namespace BBIT\DoctrineExtensions\DBAL\Logging;

use Doctrine\DBAL\Logging\SQLLogger;

class DumpSQLLogger implements SQLLogger
{
    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $sprintable = str_replace('?', '%s', $sql);

        if (is_array($params)) {
            foreach ($params as $key => $param) {
                if ($param instanceof \DateTime) {
                    $params[$key] = $param->format('d-m-Y H:i:s');
                }
            }
        }

        $clean =  vsprintf($sprintable , $params).PHP_EOL;

        file_put_contents('/tmp/queriess.txt', $clean."\n", FILE_APPEND | LOCK_EX);

        if ($params) {
            //var_dump($params);
        }

        if ($types) {
            //var_dump($types);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
    }
}
